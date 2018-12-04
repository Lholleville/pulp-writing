@extends('layouts.app')

@section('content')

   <header class="masthead">
      <div class="container d-flex h-100 align-items-center">
         @if(Auth::guest())
         <div class="col-xs-12 col-sm-9 col-md-6 col-lg-6 mx-auto text-center" id="blocklog">
               <div class="col-sm-12">
                  <div class="mx-auto">
                     <br>
                        <h1 class="mx-auto">Connexion</h1>
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                           {{ csrf_field() }}

                           <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                              <label for="name" class="col-md-4 control-label">Pseudo</label>
                              <div class="offset-md-3 col-md-6">
                                 <input id="name" type="text" class="form-control navbar-grimancie" name="name" value="{{ old('email') }}" >
                              </div>
                           </div>

                           <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                              <label for="password" class="col-md-4 control-label">Mot de passe</label>
                              <div class="offset-md-3 col-md-6">
                                 <input id="password" type="password" class="form-control navbar-grimancie" name="password">
                              </div>
                           </div>
                           @if($config->keymode_enabled)
                              <div class="form-group{{ $errors->has('accesskey') ? ' has-error' : '' }}">
                                 <label for="accesskey" class="col-md-4 control-label">Clef d'accès</label>

                                 <div class="offset-md-3 col-md-6">
                                    <input id="accesskey" type="text" class="form-control navbar-grimancie" name="accesskey">
                                 </div>
                              </div>
                           @endif
                           <div class="form-group">
                              <div class="offset-md-3 col-md-6">
                                 <div class="checkbox">
                                    <label>
                                       <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
                                    </label>
                                 </div>
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="col-md-12 ">
                                 <button type="submit" class="btn btn-dark">
                                    Connexion
                                 </button>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-xs-12">
                                 <a class="btn-link" href="{{ route('password.request') }}">
                                    Vous avez oublié votre mot de passe ?
                                 </a>
                                 <br>
                                 <a class="btn-link" href="{{ route('password.request') }}">
                                    Vous n'avez pas de compte ?
                                 </a>
                              </div>
                           </div>
                        </form>
                  </div>
               </div>
         </div>
         @else
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <h1 id="phraseaccueil">Bienvenue {{ Auth::user()->name }} !</h1>
                     <h2>Nous avons selectionné quelques textes qui pourraient vous intéresser...</h2>
                  </div>
               </div>
               <br>
               <div class="row" id="threetextspresentation">
                  @foreach($books as $book)
                     <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 library">
                        <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                           <a href="{{ url($book->collections->slug.'/'.$book->slug) }}" id="link">
                              <div class="flipper">
                                 <div class="front">
                                    {{--@if($book->isSuperliked())--}}
                                       {{--<div class="bandeau">--}}
                                          {{--<p class="text-center">Coup de coeur</p>--}}
                                       {{--</div>--}}
                                    {{--@endif--}}
                                    <div class="row">
                                       <div class="col-sm-8">
                                          <img src="{{ url($book->avatar) }}" alt="couverture de {{ $book->name }}" class=""/>
                                       </div>
                                       <div class="col-sm-4">
                                          <div class="col-sm-12">
                                             <div class="front-header">
                                                <h2 class="title-book text-rotate-270">{{ $book->name }}</h2>
                                                <h3 class="author-book text-rotate-270"><em>{{ $book->users->name }}</em></h3>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <p class="info-general">
                                       <i class="fas fa-eye"></i> {{$book->views}} <i class="fas fa-pencil-alt" aria-hidden="true"></i> {{ $book->words}}  <i class="fa fa-book" aria-hidden="true"></i>
                                       {{ $book->genres->name}}
                                    </p>
                                 </div>
                                 <div class="back">
                                    <div class="back-container row">
                                       <div class="col-sm-12">
                                          <h2 class="title-book text-center">{{ $book->name }}</h2>
                                          <h3 class="author-book text-center"><em>{{ $book->users->name }}</em></h3>
                                          <p id="summary">
                                             <span @if(strlen($book->summary) > 150 ) id="sup150{{$book->slug}}" @endif>
                                                {!! $book->summary !!}
                                             </span>
                                             <script>
                                                $('#sup150{{$book->slug}}').hover(function(){
                                                    $(this).attr('class', 'defile');
                                                });
                                             </script>

                                          </p>
                                          @if($book->parent != "")
                                             <p>
                                                Ce roman est la suite de : {{ $book->parent}}
                                             </p>
                                          @endif
                                          <p class="info-general">
                                             <i class="fas fa-eye"></i> {{$book->views}} <i class="fas fa-pencil-alt" aria-hidden="true"></i> {{ $book->words}}  <i class="fa fa-book" aria-hidden="true"></i>
                                             {{ $book->genres->name}}
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </div>
                  @endforeach
               </div>

               <div class="row" id="threetextspresentationmini">
                  @foreach($books as $book)
                     <div class="col-12">
                        <div class="row">
                           <div class="col-4">
                              <img src="{{ url($book->avatar) }}" alt="" class="img-avatar-list">
                           </div>
                           <div class="col-8">
                              <h4 class="titre-livre-mini">{{ $book->name }}</h4>
                              <h5 class="auteur-book-mini"><em>{{ $book->users->name }}</em></h5>
                              <button class="btn btn-dark" data-toggle="modal" data-target="#resume{{$book->slug}}">
                                 Lire le résumé
                              </button>
                              <a href="{{ url($book->collections->slug.'/'.$book->slug) }}" class="btn btn-light">
                                 Voir l'oeuvre
                              </a>
                           </div>
                        </div>
                     </div>
                     <br>
                     <!-- Modal -->
                     <div class="modal fade" id="resume{{$book->slug}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header" style="background-color: black; ">
                                 <h5 class="modal-title" id="exampleModalLabel">Résumé de {{$book->name}}</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <p style="color : black;">
                                    {{$book->summary}}
                                 </p>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-dark" data-dismiss="modal">Fermer</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
         @endif
      </div>
   </header>


   <section id="about" class="about-section text-center">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 mx-auto">
               <h2 class="text-white mb-4">Built with Bootstrap 4</h2>
               <p class="text-white-50">Grayscale is a free Bootstrap theme created by Start Bootstrap. It can be yours right now, simply download the template on
                  <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
            </div>
         </div>
         <img src="img/ipad.png" class="img-fluid" alt="">
      </div>
   </section>

   <!-- Projects Section -->
   <section id="projects" class="projects-section bg-light">
      <div class="container">

         <!-- Featured Project Row -->
         <div class="row align-items-center no-gutters mb-4 mb-lg-5">
            <div class="col-xl-8 col-lg-7">
               <img class="img-fluid mb-3 mb-lg-0" src="img/bg-masthead.jpg" alt="">
            </div>
            <div class="col-xl-4 col-lg-5">
               <div class="featured-text text-center text-lg-left">
                  <h4>Shoreline</h4>
                  <p class="text-black-50 mb-0">Grayscale is open source and MIT licensed. This means you can use it for any project - even commercial projects! Download it, customize it, and publish your website!</p>
               </div>
            </div>
         </div>

         <!-- Project One Row -->
         <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
            <div class="col-lg-6">
               <img class="img-fluid" src="img/demo-image-01.jpg" alt="">
            </div>
            <div class="col-lg-6">
               <div class="bg-black text-center h-100 project">
                  <div class="d-flex h-100">
                     <div class="project-text w-100 my-auto text-center text-lg-left">
                        <h4 class="text-white">Misty</h4>
                        <p class="mb-0 text-white-50">An example of where you can put an image of a project, or anything else, along with a description.</p>
                        <hr class="d-none d-lg-block mb-0 ml-0">
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Project Two Row -->
         <div class="row justify-content-center no-gutters">
            <div class="col-lg-6">
               <img class="img-fluid" src="img/demo-image-02.jpg" alt="">
            </div>
            <div class="col-lg-6 order-lg-first">
               <div class="bg-black text-center h-100 project">
                  <div class="d-flex h-100">
                     <div class="project-text w-100 my-auto text-center text-lg-right">
                        <h4 class="text-white">Mountains</h4>
                        <p class="mb-0 text-white-50">Another example of a project with its respective description. These sections work well responsively as well, try this theme on a small screen!</p>
                        <hr class="d-none d-lg-block mb-0 mr-0">
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </section>

   <!-- Signup Section -->
   <section id="signup" class="signup-section">
      <div class="container">
         <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto text-center">

               <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
               <h2 class="text-white mb-5">Subscribe to receive updates!</h2>

               <form class="form-inline d-flex">
                  <input type="email" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputEmail" placeholder="Enter email address...">
                  <button type="submit" class="btn btn-primary mx-auto">Subscribe</button>
               </form>

            </div>
         </div>
      </div>
   </section>

   <!-- Contact Section -->
   <section class="contact-section bg-black">
      <div class="container">

         <div class="row">

            <div class="col-md-4 mb-3 mb-md-0">
               <div class="card py-4 h-100">
                  <div class="card-body text-center">
                     <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                     <h4 class="text-uppercase m-0">Address</h4>
                     <hr class="my-4">
                     <div class="small text-black-50">4923 Market Street, Orlando FL</div>
                  </div>
               </div>
            </div>

            <div class="col-md-4 mb-3 mb-md-0">
               <div class="card py-4 h-100">
                  <div class="card-body text-center">
                     <i class="fas fa-envelope text-primary mb-2"></i>
                     <h4 class="text-uppercase m-0">Email</h4>
                     <hr class="my-4">
                     <div class="small text-black-50">
                        <a href="#">hello@yourdomain.com</a>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-md-4 mb-3 mb-md-0">
               <div class="card py-4 h-100">
                  <div class="card-body text-center">
                     <i class="fas fa-mobile-alt text-primary mb-2"></i>
                     <h4 class="text-uppercase m-0">Phone</h4>
                     <hr class="my-4">
                     <div class="small text-black-50">+1 (555) 902-8832</div>
                  </div>
               </div>
            </div>
         </div>

         <div class="social d-flex justify-content-center">
            <a href="#" class="mx-2">
               <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="mx-2">
               <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="mx-2">
               <i class="fab fa-github"></i>
            </a>
         </div>

      </div>
   </section>

@endsection