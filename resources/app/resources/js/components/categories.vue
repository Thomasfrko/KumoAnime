<template>
  <div>
    <ul>
      <li id = "all"><a href="/"> All </a></li>
      <li id = "watch"><a href="#toWatch"> To Watch </a></li>
      <li id = "watching"><a href="#crtlyWatching"> Currently Watching </a></li>
      <li id = "seen"><a href="#finished"> Finished</a></li>
    </ul>
  </div>
</template>

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

a {
  color: #24252a;
}

#watch a:hover{
  color:  #0088a9;
}

#watching a:hover{
  color:  #0088a9;
}

#seen a:hover{
  color: #0088a9;
}

#all a:hover {
  color:  #0088a9;
}
</style>