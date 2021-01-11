<template>
<div class="animeComponent">
  
  <div class=anime-frame>
      <a :href="'/watch/' + title">
        <div class="hover-zoom">
          <img :src="source" :alt="title">
        </div>
      </a>
      <span>{{title}}</span>
      <div class="dropdown">+
        <div class="dropdown-content">
          <form method="POST" action="/changeTag/toWatch">
            <input type="hidden" name="_token" :value="csrf">
            <button id="toWatch" type="submit" :value="title" name="changeTag">To Watch</button>
          </form>
          <form method="POST" action="/changeTag/crtlyWatching">
            <input type="hidden" name="_token" :value="csrf">
            <button id="watching" type="submit" :value="title" name="changeTag">Currently Watching</button>
          </form>
          <form method="POST" action="/changeTag/finished">
            <input type="hidden" name="_token" :value="csrf">
            <button id="finished" type="submit" :value="title" name="changeTag">Finished</button>
          </form>
          <form method="POST" action="/delete">
            <input type="hidden" name="_token" :value="csrf">
            <button id="delete" type="submit" :value="title" name="delete">X</button>
          </form>
        </div>
      </div>
    <div class="episode-notif"> {{this.keepTrack}}</div>
  </div>

  <form method="POST" action="/update">
    <input type="hidden" name="_token" :value="csrf">
    <button class="update" type="submit" name="animeToUpdate" :value="title"> Update </button>
  </form>
</div>
</template>

<script>
export default {
  props: ['title', 'source'],
  data() {
    return {
      episodeTrack: '',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
  computed: {
    keepTrack() {
      this.episodeTrack = localStorage.getItem(this.title)
      return this.episodeTrack;
    }
  }
}
</script>

<style scoped>
span {
  display: block;
  width: 257px;
  color: black;
  text-align: center;
}

img {
  width: 257px;
  height: 388px;
  text-align: center;
  border-radius: 10%;
}

.animeComponent {
  position: relative;
  align-content: center;
}

.hover-zoom {
  overflow: hidden;
  border-radius: 10%;
}

.hover-zoom img {
  transition: transform .5s ease;
  border-radius: 10%;
}

.hover-zoom:hover img {
  transform: scale(1.2);
  border-radius: 10%;
}

.anime-frame {
  position: relative;
  padding-top: 10px;
}

div.anime-frame > button {
  position: absolute;
  top: 4%;
  right: 2%;
  border-radius: 15%;
}

.episode-notif {
  position: absolute;
  top: 4%;
  left: 6%;
  border-radius: 15%;
  color: white;
  text-shadow: 1px 1px 4px black;
  font-size: 20px;
}

li {
  text-align: center;
}

.corner {
  width: 100%;
  text-align: center;
  font-size: 20px;
  display: block;
  border-radius: 15%;
  color: white;
  text-shadow: 1px 1px 4px black;
}

.corner-btn {
  border:none;
  background-color:transparent;
  outline:none;
  color: white;
  text-shadow: 2px 2px 4px black;
  font-size: 20px;
  cursor: pointer;
  padding-right: 5px;
}

.corner-btn:hover {
  color: red;
}

.dropdown {
  position: absolute;
  width: 35px;
  height: 35px;
  text-align: center;
  top: 3%;
  left: 80%;
  color: white;
  font-size: 30px;
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 5px;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #24252a;
  left: -140px;
  min-width: 180px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content button {
  border:none;
  background-color:transparent;
  outline:none;
  display: block;
  width: 100%;
  text-align: center;
  font-size: 20px;
}

#toWatch:hover {
  color:  #0088a9;
}

#watching:hover {
  color:  #0088a9;
}

#finished:hover {
  color:  #0088a9;
}

#delete:hover {
  color:  red;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.update {
  padding: 9px 25px;
  background-color: rgba(0, 136, 169, 1);
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s ease 0s;
  position: absolute;
  left: 35%;
}

.update:hover {
  background-color: rgba(0, 136, 169, 0.8);
}

</style>