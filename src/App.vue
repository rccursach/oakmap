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

    <footer class="footer">
      <div class="container">
        <div class="content has-text-centered">
          <p>
            <strong>Bulma</strong> by <a href="https://jgthms.com">Jeremy Thomas</a>. The source code is licensed
            <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
            is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
          </p>
        </div>
      </div>
    </footer>

  </div>
</template>

<script>
export default {
  components: {
  },
  name: 'app'
}
</script>

<style>
  .footer {
    margin-top: 4em;
  }
</style>

