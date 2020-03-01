<template>
  <div>
    <div class="searchBar">
      <div
        v-for="(type, index) in searchTypes"
        :key="index"
        class="searchTypes"
      >
        <SearchBySelect
          v-if="type == 'category'"
          :search="searchByCategory"
        />
        <SearchBySelect
          v-if="type == 'flux'"
          :search="searchByFlux"
        />
        <SearchBySelect
          v-if="type == 'date'"
          :search="searchByDate"
        />
        <SearchByText v-if="type == 'text'" />
      </div>
    </div>
  </div>
</template>

<script>
import SearchBySelect from "./SearchBySelect";
import SearchByText from "./SearchByText";

export default {
  name: "SearchBar",
  components: {
    SearchBySelect,
    SearchByText
  },
  props: {
    searchTypes: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      searchByCategory: {
        type: "category",
        label: "Recherche par catégorie",
        options: [
          { text: "Architecture", value: "architecture" },
          { text: "Sculpture", value: "sculpture" },
          { text: "Arts visuels", value: "visual" },
          { text: "Musique", value: "music" },
          { text: "Littérature", value: "literature" },
          { text: "Arts de la scène", value: "performing" },
          { text: "Cinéma", value: "film" }
        ]
      },
      searchByFlux: {
        type: "flux",
        label: "Trier par source",
        options: [
          { text: "Facebook", value: "facebook" },
          { text: "Twitter", value: "twitter" },
          { text: "YouTube", value: "youtube" },
          { text: "Wordpress", value: "wordpress" }
        ]
      },
      searchByDate: {
        type: "date",
        label: "Trier par date",
        options: [
          { text: "Du plus récent au plus ancien", value: "desc" },
          { text: "Du plus ancien au plus récent", value: "asc" }
        ]
      }
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.searchBar {
  display: flex;
  justify-content: space-between;
}
.searchTypes {
  width: calc(50% - var(--spacing-sm));
}
</style>
