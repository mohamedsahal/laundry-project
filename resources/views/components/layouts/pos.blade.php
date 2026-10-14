<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(isRTL() == true) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ getFavIcon() }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/file-upload.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/audioplayer.css') }}">
    <link href="{{asset('assets/plugins/toastr.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Page Title' }}</title>
   <x-theme-component/>
</head>

<body>
    {{ $slot }}
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <!-- <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <script src="{{asset('assets/plugins/toastr.min.js')}}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnific-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- prism js -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <!-- file upload js -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <!-- audioplayer -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>

    <!-- main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        // ================== Image Upload Js Start ===========================
        function readURL(input, previewElementId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewElementId).css('background-image', 'url(' + e.target.result + ')');
                    $('#' + previewElementId).hide();
                    $('#' + previewElementId).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageUpload").change(function() {
            readURL(this, 'previewImage1');
        });

        $("#imageUploadTwo").change(function() {
            readURL(this, 'previewImage2');
        });
        // ================== Image Upload Js End ===========================
    </script>
    <script>
        "use strict";
        document.addEventListener('livewire:init', () => {
            Livewire.on('closemodal', (event) => {
                $('.modal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').removeAttr('style');
            });
        });
    </script>
    <script>
        "use strict";
        document.addEventListener('livewire:init', () => {
            Livewire.on('alert', (event) => {
                toastr[event[0].type](event[0].message, 
                event[0].title ?? ''), toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                }
            });
        });
        @if(Session::has('message'))
        toastr.info("{{ Session::get('message') }}");
        @endif
    </script>
     <script>
        "use strict";
        document.addEventListener('livewire:init', () => {
            let cleanup = Livewire.on('reloadpage', (event) => {
                window.location.reload()
                console.log('reload')
            });
            cleanup();
        });
    </script>
    @stack('js')

</body>

</html>