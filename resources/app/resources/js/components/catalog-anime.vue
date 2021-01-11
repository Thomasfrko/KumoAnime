<template>
  <div>
    <ul>
      <anime v-for="anime in splitedList" :key="anime.title" :title="anime.title" :source="anime.source" :id="anime.tags"></anime>
    </ul>
  </div>
</template>

<script>
export default {
  props: [
    'title',
    'source',
    'tags'
  ],
  data() {
    return {
      animes: []      
    }
  },
  computed: {
    splitedList(){
      var filteredAnime = []
      let tagAnchor = ''
      let splitedTitles = this.title.split(',')
      let splitedSources = this.source.split(',')
      let splitedTags = this.tags.split(',')
      let newTitles = []
      let newSources = []
      let newTags = []
      splitedTitles.forEach(element => {
        element = element.replace(/[\"\]\[]/g, '');
        newTitles.push(element)
      });
      splitedSources.forEach(element => {
        element = element.replace(/[\"\]\[]/g, '');
        newSources.push(element)
      });
      splitedTags.forEach(element => {
        element = element.replace(/[\"\]\[]/g, '');
        newTags.push(element)
      });
      tagAnchor = document.URL.split('#').length > 1 ?  document.URL.split('#')[1] : null
      console.log('tagAnchor: ' + tagAnchor)
      for (let i = 0; i < newTitles.length; i++) {
        this.animes.push({'title': newTitles[i], 'source': newSources[i], 'tags': newTags[i]})
      }
      if (tagAnchor != null) {
        this.animes = this.animes.filter(anime => anime.tags == tagAnchor)
      }

      window.addEventListener('hashchange', function() {
        this.location.reload(true);
      }, false);
      return this.animes
    }
  }
}
</script>

<style scoped>
ul {
  list-style-type: none;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-evenly;
}

li {
  text-align: center;
}

h2 {
  display: inline;
  padding-left: 5%;
  padding-bottom: 3%;
}

img {
  width: 257px;
  height: 388px;
  text-align: center;
  display: block;
  border-radius: 15%;
}
.anime-frame {
  position: relative;
}
div.anime-frame > button {
  position: absolute;
  top: 2%;
  right: 5%;
  border-radius: 15%;
}
</style>