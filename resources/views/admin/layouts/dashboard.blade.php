<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ __('Administración del Sitio') }}</title>


    <!-- Custom fonts for this template-->
    <link href="{{asset('/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{asset('/vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/css/admin/sb-admin.css')}}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!--CKEditor Plugin-->
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

    <link href="{{ asset('css/upload.css') }}" rel="stylesheet">





    @yield('css_role_page')

</head>

<body id="page-top" >

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="/">{{ __('appName') }}</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->


    <!-- Navbar -->


</nav>

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">

        <!-- Divider -->
        <div class="border-top"></div>
        <!-- Heading -->


        @can('isAdmin')
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/roles') }}">
                    <i class="fa fa-unlock-alt"></i>
                    <span>{{__('Roles')}}</span></a>
            </li>
        @endcan
        @canany(['isAdmin','isManager'])
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/users') }}">
                    <i class="fas fa-user"></i>
                    <span>{{__('Users')}}</span></a>
            </li>
    @endcanany
    <!-- Divider -->
        <div class="border-top"></div>
        <!-- Heading -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/empresas') }}">
                <i class="fas fa-building"></i>
                <span>{{__('Empresas')}}</span></a>
        </li>



    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">

            @yield('content')

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © {{date('Y')}} Todos los derechos reservados.</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>



                {{-- <a class="btn btn-primary" href="login.html">Logout</a> --}}
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Page level plugin JavaScript-->

<script src="{{asset('/vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('/vendor/datatables/dataTables.bootstrap4.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/js/admin/sb-admin.js')}}"></script>

<!-- Demo scripts for this page-->
<script src="{{asset('/js/admin/demo/datatables-demo.js')}}"></script>

<!-- Scripts -->
<script src="{{ asset('js/scanner.js') }}" defer></script>

<script>
    //
    // Please read scanner.js developer's guide at: http://asprise.com/document-scan-upload-image-browser/ie-chrome-firefox-scanner-docs.html
    //

    /** Initiates a scan */
    function scanToLocalDisk(name_file) {
        scanner.scan(displayResponseOnPage,
            {
                "output_settings": [
                    {
                        "type": "save",
                        "format": "pdf",
                        "save_path": "<?php echo str_replace('\\', '/', public_path('../storage/app/public/files/'))?>"+name_file+"${EXT}"
                    }
                ]
            }
        );
    }

    /** Scan and upload in one go */
    function scanAndUploadDirectly() {
        scanner.scan(displayServerResponse,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "{{ url('/') }}/upload.php?action=dump",
                            "post_fields": {
                                "sample-field": "Test scan"
                            },
                            "cookies": document.cookie,
                            "headers": [
                                "Referer: " + window.location.href,
                                "User-Agent: " + navigator.userAgent
                            ]
                        }
                    }
                ]
            }
        );
    }

    function displayServerResponse(successful, mesg, response) {

        if(!successful) { // On error
            document.getElementById('server_response').innerHTML = 'Failed: ' + mesg;
            return;
        }

        if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('server_response').innerHTML = 'User cancelled';
            return;
        }

        document.getElementById('server_response').innerHTML = scanner.getUploadResponse(response);
    }

    function displayResponseOnPage(successful, mesg, response) {


        if(!successful) { // On error
            document.getElementById('response').innerHTML = 'Failed: ' + mesg;
            return;
        }

        if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response').innerHTML = 'User cancelled';
            return;
        }

        if(scanner.getSaveResponse(response).indexOf("DJSEC")!=-1){
            document.getElementById('hrefDJSEC').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_DJSEC.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('DJSECEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("CUIT")!=-1){
            document.getElementById('hrefCUIT').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_CUIT.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('CUITEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("RTAFIP")!=-1){
            document.getElementById('hrefRTAFIP').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_RTAFIP.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('RTAFIPEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("HABMUN")!=-1){
            document.getElementById('hrefHABMUN').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_HABMUN.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('HABMUNEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("JORLAB")!=-1){
            document.getElementById('hrefJORLAB').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_JORLAB.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('JORLABEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("DNI")!=-1){
            document.getElementById('hrefDNI').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_DNI.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('DNIEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("CONTRATO")!=-1){
            document.getElementById('hrefCONTRATO').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_CONTRATO.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('CONTRATOEscaneado').value = scanner.getSaveResponse(response);
        }
        if(scanner.getSaveResponse(response).indexOf("F931")!=-1){
            document.getElementById('hrefF931').innerHTML = '<a target="_blank" href="{{ asset('../storage/app/public/files/') }}/'+document.getElementById('nombrereal').value+'_F931.pdf"><i class="fas fa-file-pdf fa-2x"></i></a>'
            document.getElementById('F931Escaneado').value = scanner.getSaveResponse(response);
        }
        document.getElementById("formDoc").submit();

    }
    function quitar(nameFile) {
        var bool=confirm("eliminar archivo?");
        if(bool){
            switch (nameFile) {
                case "DJSEC":
                    document.getElementById('DJSECEscaneado').value ='';
                    document.getElementById('hrefDJSEC').innerHTML ='';
                    break;
                case "CUIT":
                    document.getElementById('CUITEscaneado').value ='';
                    document.getElementById('hrefCUIT').innerHTML ='';
                    break;
                case "RTAFIP":
                    document.getElementById('RTAFIPEscaneado').value ='';
                    document.getElementById('hrefRTAFIP').innerHTML ='';
                    break;
                case "HABMUN":
                    document.getElementById('HABMUNEscaneado').value ='';
                    document.getElementById('hrefHABMUN').innerHTML ='';
                    break;
                case "JORLAB":
                    document.getElementById('JORLABEscaneado').value ='';
                    document.getElementById('hrefJORLAB').innerHTML ='';
                    break;
                case "DNI":
                    document.getElementById('DNIEscaneado').value ='';
                    document.getElementById('hrefDNI').innerHTML ='';
                    break;
                case "CONTRATO":
                    document.getElementById('CONTRATOEscaneado').value ='';
                    document.getElementById('hrefCONTRATO').innerHTML ='';
                    break;
                case "F931":
                    document.getElementById('F931Escaneado').value ='';
                    document.getElementById('hrefF931').innerHTML ='';
                    break;

            }
            document.getElementById("formDoc").submit();
        }


    }
</script>

@yield('js_user_page')
@yield('js_role_page')
@yield('js_empresa_page')
@yield('js_documento_page')

</body>

</html>
