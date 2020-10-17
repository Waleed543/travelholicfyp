<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
</head>
<body>
<div  class="col-md-12" style="padding: 0; padding-top: 15px">
    <div  class="card" style="margin-left: 0">
        <div class="card-header" style="background-color: black; color: white">
            <strong class="card-title">Rooms</strong>
        </div>
        <div class="card-body">
            <div class="container text-center my-3">
                <h2 class="font-weight-light">Bootstrap 4 - Multi Item Carousel</h2>
                <div class="row mx-auto my-auto">
                    <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                        <div class="carousel-inner w-100" role="listbox">
                            <div class="carousel-item active">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=1">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=2">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=3">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=4">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=5">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-3">
                                    <div class="card card-body">
                                        <img class="img-fluid" src="http://placehold.it/380?text=6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <h5 class="mt-2">Advances one slide at a time</h5>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#myCarousel").on("slide.bs.carousel", function(e) {
            var $e = $(e.relatedTarget);
            var idx = $e.index();
            var itemsPerSlide = 0;
            var totalItems = $(".carousel-item").length;

            if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                        $(".carousel-item")
                            .eq(i)
                            .appendTo(".carousel-inner");
                    } else {
                        $(".carousel-item")
                            .eq(0)
                            .appendTo($(this).find(".carousel-inner"));
                    }
                }
            }
        });
    });



</script>
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
</body>
</html>
