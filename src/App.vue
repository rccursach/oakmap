<template>
  <div id="app">
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
          <img src="https://daks2k3a4ib2z.cloudfront.net/57966ac4a71421564bb4e66d/5835034b4c49fcf420658dab_oak-st-fav-32.png"
            alt="Oakland Tech Ecosystem" xwidth="112" xheight="28">
        </a>
        <div class="navbar-item">
          Oakland Tech Ecosystem
        </div>
      </div>
    </nav>

    <router-view/>

    <div class="foo">
      <appfooter/>
    </div>

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
  body {
    background-color: #FFFFFF;
  }
  .ui.menu .item img.logo {
    margin-right: 1.5em;
  }
  .ui.footer.segment {
    margin: 5em 0em 0em;
    padding: 5em 0em;
  }
  .wireframe {
    margin-top: 2em;
  }
  div .foo {
    margin-top: calc(100vh - 700px);
  }
</style>

