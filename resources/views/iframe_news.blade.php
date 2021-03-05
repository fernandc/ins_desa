<html>
    <head>
        <title>Noticias</title>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-Frame-Options" >
        <!--CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--DATATABLES-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.jqueryui.min.css" integrity="sha512-x2AeaPQ8YOMtmWeicVYULhggwMf73vuodGL7GwzRyrPDjOUSABKU7Rw9c3WNFRua9/BvX/ED1IK3VTSsISF6TQ==" crossorigin="anonymous" />	
        <!-- PUSHER -->
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

        <!--CHART JS-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <!--DATE BEET-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!--ACE-->
        <script src="https://pagecdn.io/lib/ace/1.4.6/ace.js" integrity="sha256-CVkji/u32aj2TeC+D13f7scFSIfphw2pmu4LaKWMSY8=" crossorigin="anonymous"></script>
        <!-- animista js -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css" integrity="sha256-a2tobsqlbgLsWs7ZVUGgP5IvWZsx8bTNQpzsqCSm5mk=" crossorigin="anonymous" />
        <!-- sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Animate -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
        <!-- PDF Reader -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js" integrity="sha256-vZy89JbbMLTO6cMnTZgZKvZ+h4EFdvPFupTQGyiVYZg=" crossorigin="anonymous"></script>
        <!--DRAGULA-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.css" integrity="sha256-EYSmiSz2daAX5Xq+m8lxGFf+qWABUgdCPUvU5X0vpI4=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.js" integrity="sha256-rVf3H94DblhP4Z6wLSa2mpMwRS5qePBWykE6QWPOaO0=" crossorigin="anonymous"></script>
        <!--jquery.basictable-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.0.9/basictable.css" integrity="sha512-9dSIGfHfnJRuJT/m92iHPvFT2ZTzVwzhG/nNyqUDA+tXCro39TX70VgRJ5O2bD64nywyiTUWtSG1JthOfjUV2w==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.0.9/jquery.basictable.js" integrity="sha512-nWpIKXCKNcC4VHVCWrWEUdaolGZTe84yIp10hGHjME3g9gBlhJzpPNRKWHUTilZ3zbcPQptz20DDNb+W4aXuWA==" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: transparent;">
        @if(isset($news))
            @foreach ($news as $new)
            <div class="card bg-light mt-2" >
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted" style="text-align: right;">{{$new["date_in"]}}</h6>
                    <h5 class="card-title">{{$new["title"]}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$new["subtitle"]}}</h6>
                    <p class="card-text" style="white-space: pre-wrap;max-height: 190px;overflow-y: auto;">{{$new["body"]}}</p>
                    <a href="{{$new["url"]}}" target="_blank" class="card-link">{{$new["text_url"]}}</a>
                </div>
            </div>
            @endforeach
        @endif
    </body>
</html>
