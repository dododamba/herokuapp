<?php


Route::auth();
Route::get('/', ['uses' => 'HomeController@home']);
Route::get('permission', 'AdminDashboardController@permission')->name('need-permission');


Route::group(['middleware' => ['web', 'auth', 'permission']], function () {
    Route::get('dashboard', ['uses' => 'HomeController@dashboard', 'as' => 'home.dashboard']);

    Route::get('token', 'Auth\\LoginController@getAccessToken')->name('api.getAccessToken');

    //users
    Route::resource('user', 'UserController');
    Route::get('user/{user}/permissions', ['uses' => 'UserController@permissions', 'as' => 'user.permissions']);
    Route::post('user/{user}/save', ['uses' => 'UserController@save', 'as' => 'user.save']);
    Route::get('user/{user}/activate', ['uses' => 'UserController@activate', 'as' => 'user.activate']);
    Route::get('user/{user}/deactivate', ['uses' => 'UserController@deactivate', 'as' => 'user.deactivate']);
    Route::post('user/ajax_all', ['uses' => 'UserController@ajax_all']);
    //roles
    Route::resource('role', 'RoleController');
    Route::get('role/{role}/permissions', ['uses' => 'RoleController@permissions', 'as' => 'role.permissions']);
    Route::post('role/{role}/save', ['uses' => 'RoleController@save', 'as' => 'role.save']);
    Route::post('role/check', ['uses' => 'RoleController@check']);

    //user administrations
    Route::get('clients', 'AdminDashboardController@client')->name('pages.client');
    Route::get('admins', 'AdminDashboardController@admin')->name('pages.admin');
    Route::get('personnels', 'AdminDashboardController@personnel')->name('pages.personnel');
    Route::get('partenaire', 'AdminDashboardController@partenaire')->name('pages.partenaire');
    Route::get('getroles', 'RoleController@index')->name('pages.getroles');

    // agence
    Route::get('agence', 'AdminDashboardController@agence')->name('pages.agence');
    // agence
    Route::get('annonces', 'AdminDashboardController@annonce')->name('pages.annonce');
    Route::get('publicite', 'AdminDashboardController@publicite')->name('pages.publicite');

    // billet
    Route::get('billet', 'AdminDashboardController@billet')->name('pages.billet');
    // Article
    Route::get('article', 'AdminDashboardController@article')->name('pages.article');
    // Classe
    Route::get('classe', 'AdminDashboardController@classe')->name('pages.classe');
    // categorie Article
    Route::get('categorie', 'AdminDashboardController@categorie')->name('pages.categorie');
    // commentaires
    Route::get('commentaire', 'AdminDashboardController@commentaire')->name('pages.commentaire');
    // Decoupage Deux
    Route::get('decoupagedeux', 'AdminDashboardController@decoupagedeux')->name('pages.decoupage-deux');
    // Decoupage Trois
    Route::get('decoupagetrois', 'AdminDashboardController@decoupagetrois')->name('pages.decoupage-trois');
    // Decoupage un
    Route::get('decoupageun', 'AdminDashboardController@decoupageun')->name('pages.decoupage-un');
    // Demande partenariat
    Route::get('demande', 'AdminDashboardController@demande')->name('pages.demande');
    // Facturationd
    Route::get('facturation', 'AdminDashboardController@facturation')->name('pages.facturation');

    // Images
    Route::get('image', 'AdminDashboardController@image')->name('pages.image');
    // Itineraire
    Route::get('itineraire', 'AdminDashboardController@itineraire')->name('pages.itineraire');
    // agence
    Route::get('like', 'AdminDashboardController@like')->name('pages.like');
    // Location
    Route::get('location', 'AdminDashboardController@location')->name('pages.location');
    //  Historique de Navigation
    Route::get('log', 'AdminDashboardController@log')->name('pages.log');
    // Mode Facturation
    Route::get('modefacturation', 'AdminDashboardController@modefacturation')->name('pages.mode-facturation');
    // Note
    Route::get('note', 'AdminDashboardController@note')->name('pages.note');
    // Pays
    Route::get('pays', 'AdminDashboardController@pays')->name('pages.pays');
    // Position Annonce
    Route::get('position', 'AdminDashboardController@position')->name('pages.position');
    // Reservation
    Route::get('reservationlocation', 'AdminDashboardController@reservationlocation')->name('pages.reservation-location');
    //  Reservation Location
    Route::get('reservationvoyage', 'AdminDashboardController@reservationvoyage')->name('pages.reservation-voyage');
    // Site Touristique
    Route::get('site', 'AdminDashboardController@site')->name('pages.site');
    // Tarif
    Route::get('tarif', 'AdminDashboardController@tarif')->name('pages.tarif-annonce');
    // transaction
    Route::get('transaction', 'AdminDashboardController@transaction')->name('pages.transaction');
    // Ville
    Route::get('ville', 'AdminDashboardController@ville')->name('pages.ville');
    // Ville itineraire
    Route::get('ville-itineraire', 'AdminDashboardController@villeitineraire')->name('pages.ville-itineraire');
    // Voyage
    Route::get('voyage', 'AdminDashboardController@voyage')->name('pages.voyage');

    Route::get('transaction', 'AdminDashboardController@transaction')->name('pages.transaction');
    // Ville
    Route::get('ville', 'AdminDashboardController@ville')->name('pages.ville');
    // Ville itineraire
    Route::get('ville-itineraire', 'AdminDashboardController@villeitineraire')->name('pages.ville-itineraire');
    // Voyage
    Route::get('voyage', 'AdminDashboardController@voyage')->name('pages.voyage');

    Route::get('type-annonce', 'AdminDashboardController@typeannonce')->name('pages.typeannonce');

    Route::get('api', 'AdminDashboardController@api')->name('pages.api');


    //  Profile management

    Route::get('profile', 'AdminDashboardController@profile')->name('pages.mon-profile');
    Route::get('profile/edit', 'AdminDashboardController@profileEdit')->name('pages.mon-profile-edit');

    Route::get('sentinel', function () {

        $user = Sentinel::getUser();
        $role = $user->role;
        $role_name = \App\Role::where('id', $role)->first();

        $is_admin = false;
        $is_client = false;
        $is_personnel = false;


        switch ($role) {
            case  1 :
                $is_admin = true;
                break;
            case  2 :
                $is_client = true;
            default :
                $is_personnel = true;

        }


        return response()->json([
            'data' => [
                'user' => $user,
                'role' => $role,
                'role_nme' => $role_name->name
            ]
        ]);
    });

});

