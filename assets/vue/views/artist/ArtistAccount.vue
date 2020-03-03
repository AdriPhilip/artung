<template>
  <div>
    <div class="topBar">
      <Header />
    </div>

    <h2 class="profil">
      Mon profil
    </h2>
    
    <!-- Formulaire de données de profil -->
    <form
      class="mx-5 px-5"
      @submit.prevent
    >
      <EditIcon />
      <FormGroup
        form-group="photoInput"
        type-status="text"
        text="Photo de profil"
        :model="user.artist.photo"
      />
      <div class="form-group">
        <label for="category">Catégorie</label>
        <select
          id="category"
          v-model="user.artist.category"
          class="form-control"
        >
          <option value="architecture">
            Architecture
          </option>
          <option value="sculpture">
            Sculpture
          </option>
          <option value="visual">
            Arts visuels
          </option>
          <option value="music">
            Musique
          </option>
          <option value="literature">
            Littérature
          </option>
          <option value="performing">
            Arts de la scène
          </option>
          <option value="film">
            Cinéma
          </option>
        </select>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea
            id="description"
            v-model="user.artist.description"
            class="form-control"
            rows="3"
          />
        </div>
      </div>
    </form>

    <hr>

    <!-- Paramètrer mes flux -->
    <span>Paramétrer mes flux</span>
    <form
      class="mx-5 px-5"
      @submit.prevent
    >
      <EditIcon />
      <FormGroupInline icon-status="facebook" />
      <FormGroupInline icon-status="twitter" />
      <FormGroupInline icon-status="youtube" />
      <FormGroupInline icon-status="wordpress" />
    </form>

    <hr>

    <!-- Formulaire de données de connexion -->
    <FormAccount />

    <hr>

    <!-- Boutons se déconnecter et supprimer mon profil -->
    <TextButton
      text="Me déconnecter"
      secondary
      @onClick="disconnect()"
    />
    <TextButton
      text="Supprimer mon profil"
      secondary
      @onClick="routerPush('DeleteAccount')"
    />
  </div>
</template>

<script>
import Header from '../../components/navs/Header'
import FormGroup from '../../components/forms/FormGroup'
import EditIcon from '../../components/buttons/EditIcon'
import FormGroupInline from '../../components/forms/FormGroupInline'
import FormAccount from '../../components/forms/FormAccount'
import TextButton from '../../components/buttons/TextButton'

export default {
  name: 'ArtistAccount',
  components: {
    Header,
    FormGroup,
    EditIcon,
    FormGroupInline,
    FormAccount,
    TextButton,
  },
  computed: {
    // Récupère les infos du user dans le Store
    user() {
      return this.$store.getters["security/user"];
    }
  },
  methods: {
    // Routes de destination des TextButton
    routerPush(name) {
      this.$router.push({ name: name });
    },
    disconnect() {
      window.location.href = window.rootUrl+'security/logout'
    }
  }
};
</script>

<style lang="scss">
.profil {
  font-size: 3em;
  color: var(--light);
  padding-top: 102px;
}
hr {
  height: var(--spacing-xs);
  background-color: var(--dark);
  border-top: 0;
}
</style>
