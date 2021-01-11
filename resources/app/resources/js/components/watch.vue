<template>
  <div>
    <select v-model="selected" class="browser-default custom-select" @change="select()">
      <option :class="hasbeenSeen(episode.numbers)" v-for="episode in splitedList" :key="episode.numbers" :value="episode.numbers">{{episode.numbers}}</option>
    </select>
    <div v-show="isVisible">
      <video id="video" @ended="ended()" :src="this.selectedEpisode" height="720" width="1200" controls></video>
    </div>
  </div>

  
</template>

<script>
export default {
  props: [
    'numbers',
    'links',
    'name'
  ], 
  data() {
    return {
      episodes: [],
      selected: '',
      selectedEpisode: '',
      isVisible: false,
    }
  },
  methods: {
    select(){
      if (this.selected.length < 1){
        this.isVisible = false
      } else {
        this.isVisible = true
        this.selectedEpisode = this.episodes[this.selected-1].links
        return this.selectedEpisode
      }
    },
    ended(){
      localStorage.setItem(this.name, this.selected)
    },
    hasbeenSeen(payload){
      if(Number(payload) <= Number(localStorage.getItem(this.name))){
        return "seen"
      }
    }
  },
  created() {
    if (localStorage.getItem(this.name) == null){
      localStorage.setItem(this.name, 0)
    }
  },
  computed: {
    splitedList(){
      let splitedNumbers = this.numbers.split(',')
      let splitedLinks = this.links.split(',')
      let newNumbers = []
      let newLinks = []
      splitedNumbers.forEach(element => {
        element = element.replace(/[\"\]\[\:\{\}a-z]/g, '');
        newNumbers.push(element)
      });
      splitedLinks.forEach(element => {
        element = element.replace(/[\"\]\[\{\}]/g, '');
        element = element.replace('links:', '')
        newLinks.push(element)
      });
      for (let i = 0; i < newNumbers.length; i++) {
        this.episodes.push({'numbers': newNumbers[i], 'links': newLinks[i]})
      }
      return this.episodes;
    },
    firstEpNotSeen(){
      if(this.selected == "NaN"){
        this.selected = 0
      }
      this.selected = (parseInt(localStorage.getItem(this.name), 10) + 1).toString()
      this.isVisible = true
      this.selectedEpisode = this.episodes[this.selected-1].links
      return [this.selected, this.isVisible, this.selectedEpisode]
    }
  }
}
</script>

<style scoped>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

video {
  top: 1rem;
  height: 100%;
  width: 100%;
  margin: 0;
  position: relative;
}

.seen {
  background-color: darkgray;
  color: white;
}

select {
  position: absolute;
  top: 1.8rem;
  width: 100%;
  height: 1rem;
  background-color: white;
  border-radius: 5px;
  border: solid 2px #0088a9;
  text-decoration: none;
}
</style>