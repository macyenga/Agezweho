<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name') }}</title>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MMMRY6PLJW"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MMMRY6PLJW');
</script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1257502818810103"
     crossorigin="anonymous"></script>
     <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "pu37b6g88s");
</script>
    <meta name="description" content="@hasSection('meta_description') @yield('meta_description') @else @isset($settings['site_seo_description']) {{ $settings['site_seo_description'] }} @endisset @endif" />
<meta name="keywords" content="@isset($settings['site_seo_keywords']) {{ $settings['site_seo_keywords'] }} @endisset" />


    <meta name="og:title" content="@yield('meta_og_title')" />
    <meta name="og:description" content="@yield('meta_og_description')" />
    <meta name="og:image" content="@isset($settings['site_logo']) {{ asset($settings['site_logo']) }} @else '' @endisset" />
    <meta name="twitter:title" content="@yield('meta_tw_title')" />
    <meta name="twitter:description" content="@yield('meta_tw_description')" />
    <meta name="twitter:image" content="@yield('meta_tw_image')" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @isset($settings['site_favicon'])
    <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image/png">
@endisset

    <link href="{{ asset('frontend/asset/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3.1.1/build/cookieconsent.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css">

    <style>
        .cc-window.cc-banner {
            padding: 1em 1.8em;
            background-color: rgba(0, 0, 0, 0.95) !important;
        }
        .cc-btn {
            border-radius: 4px !important;
            padding: 0.5em 1.2em !important;
        }
        .cc-allow {
            background-color: #4CAF50 !important;
            color: white !important;
        }
        .cc-deny {
            background-color: #f44336 !important;
            color: white !important;
        }
        .cc-link {
            color: #2196F3 !important;
            padding: 0.2em;
        }
        .cc-window {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .cc-btn {
            border-radius: 4px;
            min-width: 120px;
        }
        .cc-allow {
            background: #4CAF50 !important;
            color: white !important;
        }
        .cc-deny {
            background: #f44336 !important;
            color: white !important;
        }
    </style>

    @if(isset($settings))
    <style>
        :root {
            --colorPrimary: {{ $settings['site_color'] }};
        }
    </style>
    @endif
</head>

<body>
    <!-- Global Variables -->
    @php
        $socialLinks = \App\Models\SocialLink::where('status', 1)->get();
        $footerInfo = \App\Models\FooterInfo::where('language', getLanguage())->first();
        $footerGridOne = \App\Models\FooterGridOne::where(['status' => 1, 'language' => getLanguage()])->get();
        $footerGridTwo = \App\Models\FooterGridTwo::where(['status' => 1, 'language' => getLanguage()])->get();
        $footerGridThree = \App\Models\FooterGridThree::where(['status' => 1, 'language' => getLanguage()])->get();
        $footerGridOneTitle = \App\Models\FooterTitle::where(['key' => 'grid_one_title', 'language' => getLanguage()])->first();
        $footerGridTwoTitle = \App\Models\FooterTitle::where(['key' => 'grid_two_title', 'language' => getLanguage()])->first();
        $footerGridThreeTitle = \App\Models\FooterTitle::where(['key' => 'grid_three_title', 'language' => getLanguage()])->first();
    @endphp

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->


    @yield('content')

    {{-- Footer Section --}}
    @include('frontend.layouts.footer')

    {{-- End Footer Section --}}

    <footer>
        <div class="footer-terms" style="text-align: center; padding: 20px; background-color: #f8f9fa; border-top: 1px solid #e7e7e7;">
            <a href="{{ url('/terms-and-conditions') }}" style="color: #007bff; text-decoration: none; margin-right: 15px;">Terms of Service</a> | 
            <a href="{{ url('/privacy-policy') }}" style="color: #007bff; text-decoration: none; margin-left: 15px;">Privacy Policy</a>
        </div>
    </footer>

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/asset/js/index.bundle.js') }}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        // Add csrf token in ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            /** change language **/
            $('#site-language').on('change', function() {
                let languageCode = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(data) {
                        console.error(data);
                    }
                })
            })

            /** Subscribe Newsletter**/
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.newsletter-button').text('loading...');
                        $('.newsletter-button').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            $('.newsletter-form')[0].reset();
                            $('.newsletter-button').text('sign up');

                            $('.newsletter-button').attr('disabled', false);
                        }
                    },
                    error: function(data) {
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);

                        if (data.status === 422) {
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(index, value) {
                                Toast.fire({
                                    icon: 'error',
                                    title: value[0]
                                })
                            })
                        }
                    }
                })
            })
        })
    </script>
    
    @stack('content')
    <script src="{{ mix('js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3.1.1/build/cookieconsent.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>
    <script>
    window.addEventListener('load', function() {
        window.cookieconsent.initialise({
            palette: {
                popup: {
                    background: '#2b2b2b',
                    text: '#ffffff'
                },
                button: {
                    background: '#4CAF50'
                }
            },
            type: 'opt-in',
            content: {
                message: 'This website uses cookies to improve your experience and provide personalized content.',
                allow: 'Accept cookies',
                deny: 'Decline',
                link: 'Learn more',
                href: '/privacy-policy'
            },
            onInitialise: function(status) {
                var type = this.options.type;
                var didConsent = this.hasConsented();
                if (didConsent) {
                    enableCookies();
                }
            },
            onStatusChange: function(status, chosenBefore) {
                var type = this.options.type;
                var didConsent = this.hasConsented();
                if (didConsent) {
                    enableCookies();
                } else {
                    disableCookies();
                }
            }
        });
    });

    function enableCookies() {
        window['ga-disable-G-MMMRY6PLJW'] = false;
        gtag('consent', 'update', {
            'analytics_storage': 'granted'
        });
    }

    function disableCookies() {
        window['ga-disable-G-MMMRY6PLJW'] = true;
        gtag('consent', 'update', {
            'analytics_storage': 'denied'
        });
    }
    </script>

</body>
</html>
