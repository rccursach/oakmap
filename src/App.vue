<template>
  <div id="app">
    <div class="ui fixed menu">
      <div class="ui container">
        <a href="/" class="header item">
          Oakland Tech Ecosystem
        </a>
        <!--
        <a href="#" class="item">Home</a>
        <div class="ui simple dropdown item">
          Dropdown <i class="dropdown icon"></i>
          <div class="menu">
            <a class="item" href="#">Link Item</a>
            <a class="item" href="#">Link Item</a>
            <div class="divider"></div>
            <div class="header">Header Item</div>
            <div class="item">
              <i class="dropdown icon"></i>
              Sub Menu
              <div class="menu">
                <a class="item" href="#">Link Item</a>
                <a class="item" href="#">Link Item</a>
              </div>
            </div>
            <a class="item" href="#">Link Item</a>
          </div>
        </div>
        !-->
      </div>
    </div>

    <router-view/>
    
    <appfooter/>

  </div>
</template>

<script>
import Footer from './components/Footer'
export default {
  components: {
    appfooter: Footer
  },
  name: 'app'
}
</script>

<style>

</style>

