<template>
   <div class="list-group">
    <form method="POST" action="/add">
      <input type="hidden" name="_token" :value="csrf">
      <button v-for="link in splitedList" :key="link" class="list-group-item list-group-item-action" type="submit" name="linkChosen" :value="link.link">{{link.alt}}</button>
    </form>
  </div>
</template>

<script>
export default {
  props:[
    'links',
    'link',
    'alt'
  ],
  data() {
    return {
      linksData: [],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
  computed: {
    splitedList(){ //Récupère les liens et extirpe le nom de l'anime pour l'afficher dans le bouton
      
      let splitedLinks = this.links.split(',')
      let newLinks = []
      let linksAlt = []
      splitedLinks.forEach(element => { // On supprime les caractères spéciaux
        var finalAlt = ''
        element = element.replace(/[\"\]\[]/g, '');
        newLinks.push(element)
        element = element.split('/').pop().replace(/[-]/g, ' ')
        var matches = element.match(/([a-zA-Z])+/g)
        matches.forEach(match => {
          finalAlt += match.charAt(0).toUpperCase() + match.slice(1) + ' '
        })
        linksAlt.push(finalAlt)

      });
      for (let i = 0; i < newLinks.length; i++) {
        this.linksData.push({'link': newLinks[i], 'alt': linksAlt[i]})
      }
      return this.linksData
    }
  }
}
</script>

<style scoped>
button {

  display: flex;
  flex-direction: column;
  color: #BFC0C0;
  text-decoration: none;
  font-size: .8em;
  cursor: pointer; 
  justify-content: center;
  overflow: hidden;
  position: relative;
  width: 80%;
  margin-left: 10%;
  background-color: #24252a;
}

button:hover {
  color: #0088a9;
}

</style>