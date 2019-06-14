<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function client()
    {
        return View('users.client');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        return View('users.admin');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function log()
    {
        return View('users.log');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function personnel()
    {
        return View('users.personnel');
    }

     /**
     * return roles pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function getroles()
    {
        return View('users.role');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function agence()
    {
        return View('agence.index');
    }


    /**
     * return annonce pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function annonce()
    {
        return View('annonce.liste');
    }
    /**
     * return createannonce pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function createannonce()
    {
        return View('annonce.create');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function billet()
    {
        return View('billet.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function article()
    {
        return View('article.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function classe()
    {
        return View('classe.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function categorie()
    {
        return View('categorie.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function decoupagedeux()
    {
        return View('decoupagedeux.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function decoupagetrois()
    {
        return View('decoupagetrois.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function decoupageun()
    {
        return View('decoupageun.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function commentaire()
    {
        return View('commentaire.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function demande()
    {
        return View('demande.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function image()
    {
        return View('image.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function itineraire()
    {
        return View('itineraire.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function location()
    {
        return View('location.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function modefacturation()
    {
        return View('modefacturation.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function note()
    {
        return View('note.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function pays()
    {
        return View('pays.index');
    }


    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function partenaire()
    {
        return View('partenaire.index');
    }


    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function position()
    {
        return View('position.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function site()
    {
        return View('site.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function tarif()
    {
        return View('tarif.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction()
    {
        return View('transaction.index');
    }

/**
     * return annonce pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeannonce()
    {
        return View('annonce.typeannonce');
    }
    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function ville()
    {
        return View('ville.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function villeitineraire()
    {
        return View('villeitineraire.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function voyage()
    {
        return View('voyage.index');
    }

   public function permission()
   {
    return View('permission');
   }

    public function profile()
    {
        return view('profile.profile');
     }

    public function profileEdit()
    {
        return view('profile.edit');
     }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        return View('api.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function like()
    {
        return View('like.index');
    }

    /**
     * return clients pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function facturation()
    {
        return View('facturation.index');
    }
}
