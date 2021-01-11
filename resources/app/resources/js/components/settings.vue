<template>
  <div class="wrapper">
    <nav class="sidenav">
      <ul>
        <li><a href="/settings/customisation">Customisation</a></li>
        <li><a href="/settings/categories">Categories</a></li>
      </ul>
    </nav>
    <div class="content"> {{content}} </div>
  </div>
</template>

<script>
export default {
  props: [
    'content'
  ]
}
</script>

<style scoped>

.sidenav{
  display: flex;
  flex-direction: column;
  height: 100%;
  width: 8rem;
  position: fixed;
  background-color: #3a3c42;
  top: 0;
  left: 0;
  overflow-x: hidden;
  margin-top: 1.8rem;
}

.sidenav li {
  padding-left: 10px;
}

.content {
  position: relative;
  margin-left: 9rem;
  overflow: hidden;
}

</style>