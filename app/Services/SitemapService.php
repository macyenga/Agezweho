<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use Carbon\Carbon;

class SitemapService
{
    public function generate()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0));

        // Add all posts
        Post::all()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/posts/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        // Store the sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
