<div class="row">
    <div class="col-sm-12">
        <h2>Table des matières</h2>

        <table class="table">
            <thead>
            <tr>
                <th>
                    Ordre
                </th>
                <th>
                    Chapitre
                </th>
                <th>
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </th>
                <th>
                    <i class="fas fa-comments" aria-hidden="true"></i>
                </th>
                <th>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($book->chapters as $chapter)
                <tr class="tr-hover">
                    <td><a href="{{$book->slug}}/{{$chapter->order}}/{{$chapter->slug}}">{{ $chapter->order }}</a></td>
                    <td><a href="{{$book->slug}}/{{$chapter->order}}/{{$chapter->slug}}">{{ $chapter->name }}</a></td>
                    <td><a href="{{$book->slug}}/{{$chapter->order}}/{{$chapter->slug}}">{{ $chapter->views }}</a></td>
                    <td><a href="{{$book->slug}}/{{$chapter->order}}/{{$chapter->slug}}">{{ $chapter->nbComments }}</a></td>
                    <td><a href="{{$book->slug}}/{{$chapter->order}}/{{$chapter->slug}}">{{ $chapter->like }}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

</div>