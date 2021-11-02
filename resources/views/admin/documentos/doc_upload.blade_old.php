<!DOCTYPE html>
<html>
<head>
    <title>How to upload a file in Laravel 8</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/upload.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/scanner.js') }}" defer></script>




</head>
<body>

<div class="container">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!-- Alert message (start) -->
            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class') }}">
                    {{ Session::get('message') }}
                </div>
        @endif
        <!-- Alert message (end) -->

            <form action="{{route('uploadFile')}}" enctype='multipart/form-data' method="post" >
                {{csrf_field()}}

                <div class="form-group">
                <!--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">File <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <input type='file' name='file' class="form-control">

                        @if ($errors->has('file'))
                            <span class="errormsg text-danger">{{ $errors->first('file') }}</span>
                        @endif
                    </div>-->
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <!--<input type="submit" name="submit" value='Submit' class='btn btn-success'>-->
                        <button type="button" onclick="scanAndUploadDirectly();" class='btn btn-success'>Escanear</button>
                    </div>
                </div>
                <div id="server_response"></div>
            </form>

        </div>
    </div>
</div>
<script>
    //
    // Please read scanner.js developer's guide at: http://asprise.com/document-scan-upload-image-browser/ie-chrome-firefox-scanner-docs.html
    //

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
</script>
</body>
</html>
