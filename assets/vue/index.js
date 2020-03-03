import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './variables';

// Imports fontawesome
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
// Définir ici les icones à utiliser.
import {
  faHome,
  faHeart,
  faMusic,
  faCheck,
  faStar,
  faPaintBrush,
  faUniversity,
  faScrewdriver,
  faBook,
  faTheaterMasks,
  faFilm,
  faQuestion,
  faEdit,
  faCheckSquare,
  faSortDown,
  faExternalLinkAlt
} from '@fortawesome/free-solid-svg-icons';
import {
  faHeart as farHeart,
  faStar as farStar,
} from '@fortawesome/free-regular-svg-icons';
import {
  faFacebook,
  faTwitter,
  faYoutube,
  faWordpress,
} from '@fortawesome/free-brands-svg-icons';

Vue.component('font-awesome-icon', FontAwesomeIcon);
// Ajouter les icones à la librairie
library.add(
  faHome,
  faHeart,
  farHeart,
  faMusic,
  faFacebook,
  faTwitter,
  faYoutube,
  faWordpress,
  faCheck,
  faStar,
  farStar,
  faPaintBrush,
  faUniversity,
  faScrewdriver,
  faBook,
  faTheaterMasks,
  faFilm,
  faQuestion,
  faEdit,
  faCheckSquare,
  faSortDown,
  faExternalLinkAlt
);

export const searchBus = new Vue();
export const readonlyBus = new Vue();
export const favBus = new Vue();

Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
  router,
  store,
}).$mount('#app');

// Permet de rediriger vers la page de login si l'utilisateur tente d'accéder à une page nécessitant d'être loggé.
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
