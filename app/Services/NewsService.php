<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsService
{
    protected $inappropriateContent = [
        'adult', 'gambling', 'betting', 'casino', 'porn', 'xxx', 
        'violence', 'gore', 'hate', 'racism', 'drugs', 'illegal'
    ];

    protected function validateContent($content)
    {
        // Check for minimum content length
        if (strlen($content) < 50) return false;

        // Check for inappropriate content
        $contentLower = strtolower($content);
        foreach ($this->inappropriateContent as $term) {
            if (strpos($contentLower, $term) !== false) {
                return false;
            }
        }

        // Check for spam patterns
        if (preg_match('/\b(click here|buy now|free|cheap)\b/i', $content)) {
            return false;
        }

        return true;
    }

    protected function enrichArticle($article, $isLocal = false)
    {
        if (!$article) {
            return null;
        }

        try {
            $content = $isLocal ? 
                ($article->content ?? '') : 
                ($article['description'] ?? '');
            
            if (!$this->validateContent($content)) {
                return null;
            }

            return [
                'title' => $isLocal ? 
                    ($article->title ?? '') : 
                    ($article['title'] ?? ''),
                'content' => $content,
                'category' => [
                    'name' => $isLocal ? 
                        optional($article->category)->name ?? 'Uncategorized' : 
                        $this->determineCategory($article['title'] . ' ' . $content)
                ],
                'author' => [
                    'name' => $isLocal ? 
                        optional($article->author)->name ?? 'Anonymous' : 
                        ($article['author'] ?? 'External Source')
                ],
                'source' => [
                    'name' => $isLocal ? config('app.name') : ($article['source']['name'] ?? 'External Source'),
                    'url' => $isLocal ? config('app.url') : ($article['url'] ?? '#')
                ],
                'publishedAt' => $isLocal ? 
                    optional($article->created_at) ?? now() : 
                    Carbon::parse($article['publishedAt'] ?? now()),
                'image' => $isLocal ? 
                    ($article->image ?? null) : 
                    ($article['urlToImage'] ?? null),
                'isLocal' => $isLocal,
                'slug' => $isLocal ? 
                    ($article->slug ?? Str::slug($article->title)) : 
                    Str::slug($article['title'] ?? ''),
                'attribution' => !$isLocal ? [
                    'required' => true,
                    'text' => 'Content provided by ' . ($article['source']['name'] ?? 'News API'),
                    'link' => $article['url'] ?? '#'
                ] : null
            ];
        } catch (\Exception $e) {
            \Log::error('Error enriching article: ' . $e->getMessage());
            return null;
        }
    }

    protected function mergeAndSortContent($localContent, $externalContent)
    {
        $merged = collect()
            ->concat($localContent)
            ->concat($externalContent)
            ->filter()
            ->sortByDesc('publishedAt')
            ->take(10);

        // Ensure at least 30% local content
        $localCount = $merged->where('isLocal', true)->count();
        $totalCount = $merged->count();
        
        if ($totalCount > 0 && ($localCount / $totalCount) < 0.3) {
            $merged = $merged->take(5); // Reduce total if not enough local content
        }

        return $merged->values();
    }

    public function getRecentNews($limit = 6)
    {
        $localNews = $this->getLocalRecentNews($limit);
        $externalNews = $this->getExternalRecentNews($limit);
        
        return $this->mergeAndSortContent($localNews, $externalNews);
    }

    protected function getLocalRecentNews($limit)
    {
        return News::with(['category', 'author'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('created_at', 'DESC')
            ->take($limit)
            ->get();
    }

    protected function getExternalRecentNews($limit)
    {
        return Cache::remember('external_recent_news', 1800, function () use ($limit) {
            try {
                $response = Http::get('https://newsapi.org/v2/everything', [
                    'language' => 'en',
                    'pageSize' => $limit,
                    'sortBy' => 'publishedAt',
                    'apiKey' => config('services.newsapi.key'),
                ]);

                if ($response->successful()) {
                    return array_slice($response->json()['articles'] ?? [], 0, $limit);
                }
            } catch (\Exception $e) {
                \Log::error('External recent news API error: ' . $e->getMessage());
            }
            return [];
        });
    }

    protected function mergeRecentNews($localNews, $externalNews)
    {
        $formattedLocal = $localNews->map(function ($news) {
            return $this->enrichArticle($news, true);
        });

        $formattedExternal = collect($externalNews)->map(function ($news) {
            return $this->enrichArticle($news, false);
        })->filter();

        return $this->mergeAndSortContent($formattedLocal, $formattedExternal);
    }

    protected function getExternalNews($endpoint, $params = [])
    {
        return Cache::remember("external_news_{$endpoint}", 1800, function () use ($endpoint, $params) {
            try {
                $response = Http::timeout(5)
                    ->retry(2, 100)
                    ->get("https://newsapi.org/v2/{$endpoint}", array_merge([
                        'language' => 'en',
                        'apiKey' => config('services.newsapi.key'),
                    ], $params));

                if ($response->successful()) {
                    $data = $response->json();
                    \Log::info("News API response for {$endpoint}: " . json_encode([
                        'status' => $data['status'] ?? 'unknown',
                        'count' => count($data['articles'] ?? [])
                    ]));
                    return $data['articles'] ?? [];
                }
            } catch (\Exception $e) {
                \Log::error("News API error for {$endpoint}: " . $e->getMessage());
            }
            return [];
        });
    }

    // ...existing code...
}
