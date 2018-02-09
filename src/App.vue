<template>
  <div id="app">
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href="#" aria-role="presentation">
          <img src="https://daks2k3a4ib2z.cloudfront.net/57966ac4a71421564bb4e66d/5835034b4c49fcf420658dab_oak-st-fav-32.png"
            alt="Oakland Tech Ecosystem" xwidth="112" xheight="28" aria-hidden="true">
        </a>
        <div class="navbar-item" tabindex="0">
          Oakland Tech Ecosystem
        </div>
      </div>
      <div class="navbar-menu">
        <!--
        <div class="navbar-start">
        </div>
        -->
        <div class="navbar-end">
          <div class="navbar-item is-pulled-right">
            <portal-target name="search-form"></portal-target>
          </div>
        </div>
      </div>
    </nav>

    <router-view/>

    <footer class="footer" aria-describedby="footer-text">
      <div class="container">
        <div class="content has-text-centered">
          <p id="footer-text">
            <strong>Oakland Tech Ecosystem</strong> - A project of the Oakland Startup Network and the Alliance for Community Development.
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
    /* position: fixed;
    bottom: 0;
    right: 0;
    width: 100%; */
    margin-top: 4em;
  }
  nav.navbar {
    -webkit-box-shadow: 0px 3px 0px 0px rgba(40, 40, 40, 0.2);
    -moz-box-shadow:    0px 3px 0px 0px rgba(40, 40, 40, 0.2);
    box-shadow:         0px 3px 0px 0px rgba(40, 40, 40, 0.2);
  }
</style>

