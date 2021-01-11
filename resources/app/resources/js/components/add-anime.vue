<template>
  <div>
    <form method="POST" action="/search">
      <input type="hidden" name="_token" :value="csrf">
      <div>
        <input type="text" class="form-control" name="animeName" placeholder="Anime Title" v-model="newAnime">
        <div>
          <button type="submit">Add Anime</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newAnime: this.newAnime,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  } 
}
</script>

<style scoped>
input {
  border: 2px solid;
  border-radius: 4px;
  font-size: 1rem;
  margin: 0.25rem;
  min-width: 125px;
  padding: 0.5rem;
  transition: border-color 0.5s ease-out;
}

button {
  padding: 9px 25px;
  background-color: rgba(0, 136, 169, 1);
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s ease 0s;
  position: absolute;
  left: 0.25rem;
}
</style>