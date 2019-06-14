<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="#">
            </div>
        </a>
        <a href="#" class="simple-text logo-normal">
            G-voyage

        </a>
    </div>
    <div class="sidebar-wrapper ps-container ps-theme-default ps-active-x ps-active-y scrolling-wrapper" >
        <div class="user">
            <div class="photo">
                <img src="../../assets/img/faces/ayo-ogunseinde-2.jpg">
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                        <span>
                           Ned Stark
                          <b class="caret"></b>
                        </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('pages.mon-profile') }}">
                                <span class="sidebar-normal">Mon Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('pages.mon-profile-edit')}}">
                                <span class="sidebar-normal">Editer Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-normal">Paramètres</span>
                            </a>
                        </li>
                        {!! Form::open(['url' => url('logout'),'class'=>'form-inline']) !!}
                        {!! csrf_field() !!}
                        <li>
                            <button class="btn btn-simple btn-wd" type="submit">Se Deconnecter</button>
                        </li>
                        {!! Form::close() !!}

                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li>
                <a href="./dashboard.html">
                    <i class="nc-icon nc-bank"></i>
                    <p>Tableau de bord</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="fa fa-spinner text-right"></i>
                    <p>
                        Partenaire & Offres
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="pagesExamples">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="{{ route('pages.partenaire')}}">
                                <span class="sidebar-normal"> Partenaires </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{ route('pages.voyage')}}">
                                <span class="sidebar-normal"> Voyage </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{route('pages.location')}}">
                                <span class="sidebar-normal"> Location </span>
                            </a>
                        </li>

                        <li class="text-center">
                            <a href="{{ route('pages.classe') }}">
                                <span class="sidebar-normal"> Classe </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li>
                <a data-toggle="collapse" href="#annoncepub">
                    <i class="fa fa-exclamation-triangle text-right"></i>
                    <p>
                        Annonces & Pubs
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="annoncepub">
                    <ul class="nav">
                        <li class="text-center">
                            <a data-toggle="collapse" href="#annonce">
                                <span class="sidebar-normal"> Annonces </span>
                            </a>
                            <div class="collapse" id="annonce">
                                <ul class="nav">
                                    <li class="text-right">
                                        <a href="{{route('pages.annonce')}}">
                                            <span class="sidebar-normal"> Annonces </span>
                                        </a>
                                    </li>
                                    <li class="text-right">
                                        <a href="{{route('pages.typeannonce')}}">
                                            <span class="sidebar-normal"> Type annonce </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="text-center">
                            <a href="#">
                                <span class="sidebar-normal"> Publicités </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link btn-magnify" href="{{ route('pages.transaction') }}"><i
                            class="fa fa-money text-right"></i>
                    <p><span>Transaction</span></p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-magnify" href="#"><i class="fa fa-sticky-note-o text-right"></i>
                    <p><span>Facturations</span></p></a>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-magnify" href="{{route('pages.image')}}"><i class="fa fa-camera text-right"></i>
                    <p><span>Gallerie</span></p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-magnify" href="{{route('pages.site')}}"><i
                            class="fa fa-map-marker text-right"></i>
                    <p><span>Sites Touristiques</span></p></a>

            </li>


            <li>
                <a data-toggle="collapse" href="#comments">
                    <i class="fa fa-commenting-o text-right"></i>
                    <p>
                        Commentaires
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="comments">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="{{ route('pages.commentaire') }}">
                                <span class="sidebar-normal">Commentaires </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{route('pages.note')}}">
                                <span class="sidebar-normal">Notes </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li>
                <a data-toggle="collapse" href="#city">
                    <i class="fa fa-building-o text-right"></i>
                    <p>
                        Localités
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="city">
                    <ul class="nav">
                        <li class="text-center">
                            <a data-toggle="collapse" href="#decoupage">
                                <span class="sidebar-normal"> Decoupages </span>
                            </a>
                            <div class="collapse" id="decoupage">
                                <ul class="nav">
                                    <li class="text-right">
                                        <a href="{{route('pages.decoupage-un')}}">
                                            <span class="sidebar-normal"> Découpage un </span>
                                        </a>
                                    </li>
                                    <li class="text-right">
                                        <a href="{{route('pages.decoupage-deux')}}">
                                            <span class="sidebar-normal"> Découpage deux </span>
                                        </a>
                                    </li>
                                    <li class="text-right">
                                        <a href="{{route('pages.decoupage-trois')}}">
                                            <span class="sidebar-normal"> Découpage Trois </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="text-center">
                            <a href="{{ route('pages.ville') }}">
                                <span class="sidebar-normal"> Villes </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{route('pages.pays')}}">
                                <span class="sidebar-normal"> Pays </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li>
                <a data-toggle="collapse" href="#users">
                    <i class="fa fa-users text-right"></i>
                    <p>
                        Utilisateurs
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="users">
                    <ul class="nav">
                        <li class="text-center">
                            <a href="{{ route('pages.client') }}">
                                <span class="sidebar-normal"> Clients </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{ route('pages.personnel') }}">
                                <span class="sidebar-normal"> Personnel </span>
                            </a>
                        </li>
                        <li class="text-center">
                            <a href="{{ route('pages.getroles') }}">
                                <span class="sidebar-normal"> Role & Permissions </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link btn-magnify" href="{{route('pages.log')}}"><i class="fa fa-globe text-right"></i>
                    <p><span>Historiques</span></p></a>
            </li>


        </ul>
    </div>
</div>
