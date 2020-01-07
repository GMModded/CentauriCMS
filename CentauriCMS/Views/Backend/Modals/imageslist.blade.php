{{-- <table class="table table-hover">
    <thead>
        <th>
            Selected
        </th>

        <th>
            Image
        </th>

        <th>
            Name
        </th>

        <th>
            Type
        </th>
    </thead>

    <tbody>
        @foreach($images as $image)
            <tr>
                <td>
                    <div class="form-check">
                        @if(in_array($image->uid, $uidArr))
                            <input type="checkbox" class="form-check-input" id="image_{{ $image->uid }}" checked>
                        @else
                            <input type="checkbox" class="form-check-input" id="image_{{ $image->uid }}">
                        @endif

                        <label class="form-check-label" for="image_{{ $image->uid }}"></label>
                    </div>
                </td>

                <td class="text-center">
                    <img src="{!! ImageBladeHelper::getPath($image->uid) !!}" class="img-fluid" style="max-width: 175px;" />
                </td>

                <td>
                    {{ $image->name }}
                </td>

                <td>
                    {{ $image->type }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="row">
    <div class="col-md-12">

        <div id="mdb-lightbox-ui"></div>

        <div class="mdb-lightbox">


            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(114).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(114).jpg" class="img-fluid">
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(42).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(42).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(43).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(43).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(45).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(45).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(46).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(46).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(47).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(47).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(48).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(48).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(49).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(49).jpg" class="img-fluid" />
                </a>
            </figure>

            <figure class="col-md-4">
                <a href="https://mdbootstrap.com/img/Photos/Horizontal/Nature/12-col/img%20(51).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(51).jpg" class="img-fluid" />
                </a>
            </figure>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
    });
</script>
