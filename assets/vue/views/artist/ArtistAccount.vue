<template>
  <div>
    <Header />

    <!-- Formulaire de données de profil -->
    <form @submit.prevent>
      <EditIcon />
      <FormGroup
        form-group="photoInput"
        type-status="text"
        text="Photo de profil"
      />
      <div class="form-group">
        <label for="category">Catégorie</label>
        <select
          id="category"
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
            class="form-control"
            rows="3"
          />
        </div>
      </div>
    </form>

    <hr>

    <!-- Paramètrer mes flux -->
    <span>Paramétrer mes flux</span>
    <form @submit.prevent>
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
      @onClick="routerPush('Home', '')"
    />
    <TextButton
      text="Supprimer mon profil"
      secondary
      @onClick="routerPush('DeleteAccount', '')"
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
  }
};
</script>

<style lang="scss">
hr {
  height: var(--spacing-xs);
  background-color: var(--dark);
  border-top: 0;
}
</style>
