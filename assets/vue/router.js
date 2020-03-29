import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

// Import des composants
import Logo from './components/Logo';
import Home from './views/Home';
import Register from './views/Register';
import DeleteAccount from './views/DeleteAccount';
import Login from './views/Login';
import FanAccount from './views/fan/FanAccount';
import ArtistAccount from './views/artist/ArtistAccount';
import ArtistDetails from "./views/artist/ArtistDetails";

// Définition des routes
const routes = [
  // Route Artist
  {
    name: 'ArtistAccount',
    path: '/artist/account',
    component: ArtistAccount,
    meta: {
      requiresAuth: {
        roles: ['ROLE_ARTIST'],
      },
    }, 
  },
  // Routes générales
  {
    name: 'Logo',
    path: '/',
    component: Logo,
  },
  {
    name: 'Home',
    path: '/home',
    component: Home,
  },
  {
    name: 'ArtistDetails',
    path: '/artist/:id',
    component: ArtistDetails,
    props: true,
  },
  {
    name: 'Register',
    path: '/register',
    component: Register,
    props: true,
  },
  {
    name: 'DeleteAccount',
    path: '/delete-account',
    component: DeleteAccount,
  },
  {
    name: 'Login',
    path: '/login',
    component: Login,
    props: true,
  },
  // Route Fan
  {
    name: 'FanAccount',
    path: '/fan/account',
    component: FanAccount,
    meta: {
      requiresAuth: {
        roles: ['ROLE_FAN'],
      },
    }, 
  },
];

//Création du routeur.
const router = new VueRouter({
  mode: 'history',
  routes,
});

// Test si l'utilisateur est identifié à chaque route
router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters['security/isAuthenticated']) {
      next();
    } else {
      next({
        path: '/login',
        query: {redirect: to.fullPath},
      });
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router;
