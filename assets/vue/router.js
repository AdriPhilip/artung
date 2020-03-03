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
import ArtistDetails from './views/fan/ArtistDetails';
import FanAccount from './views/fan/FanAccount';
import ArtistAccount from './views/artist/ArtistAccount';
import ArtistPreview from './views/artist/ArtistPreview';
// Routes test
import Adrien from './views/test/Adrien';
import Alice from './views/test/Alice';
import Aude from './views/test/Aude';
import Steve from './views/test/Steve';

// Définition des routes
const routes = [
  {
    name: "Logo",
    path: "/",
    component: Logo
  },
  {
    name: "Home",
    path: "/home",
    component: Home
  },
  {
    name: "ArtistDetails",
    path: "/home/artist/:id",
    component: ArtistDetails,
    props: true
  },
  {
    name: "Register",
    path: "/register",
    component: Register,
    props: true
  },
  {
    name: "DeleteAccount",
    path: "/delete-account",
    component: DeleteAccount
  },
  {
    name: "Login",
    path: "/login",
    component: Login,
    props: true
  },
  // Routes Fan
  {
    name: "FanAccount",
    path: "/fan/account",
    component: FanAccount
    /*     meta: {
      requiresAuth: {
        roles: ['ROLE_FAN'],
      },
    }, */
  },
  // Routes Artist
  {
    name: "ArtistAccount",
    path: "/artist/account",
    component: ArtistAccount
    /*     meta: {
      requiresAuth: {
        roles: ['ROLE_ARTIST'],
      },
    }, */
  },
  {
    name: "ArtistPreview",
    path: "/artist/preview",
    component: ArtistPreview
    /*     meta: {
      requiresAuth: {
        roles: ['ROLE_ARTIST'],
      },
    }, */
  },
  // Routes Test
  {
    name: "Adrien",
    path: "/adrien",
    component: Adrien
  },
  {
    name: "Alice",
    path: "/alice",
    component: Alice
  },
  {
    name: "Aude",
    path: "/aude",
    component: Aude
  },
  {
    name: "Steve",
    path: "/steve",
    component: Steve
  }
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
