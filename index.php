<?php
$data_read = file_get_contents('/Users/jose/dev/osn_mappingdata/data/data.oaktown.v1.json');
$data = json_decode($data_read); //var_dump( count($data) );

?><!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <!-- Site Properties -->
  <title>Oakland Tech Ecosystem Map</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">

  <script src=//unpkg.com/vue></script>
  <script src=//unpkg.com/vuebars@0.1.1></script>

  <style type="text/css">
  body {
    background-color: #FFFFFF;
  }
  .ui.menu .item img.logo {
    margin-right: 1.5em;
  }
  .main.container {
    margin-top: 2em;
  }
  .wireframe {
    margin-top: 2em;
  }
  .ui.footer.segment {
    margin: 5em 0em 0em;
    padding: 5em 0em;
  }

  </style>
</head>
<body>

<div class="ui fixed menu">
  <div class="ui container">
    <a href="#" class="header item">
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

<div class="ui stackable responsive grid main container">
  <div class="row">
    <div class="six wide column">
      
      <form class="ui form">
        <h4 class="ui dividing header">Find a good fit:</h4>

        <div class="field">
          <div class="ui icon input">
            <i class="search icon"></i>
            <input type="text" placeholder="Search...">
          </div>
        </div>

        <div class="field">
          <label>Stage</label>
          <select class="ui fluid dropdown">
            <option value="">Inspire</option>
            <option value="free">Plan</option>
            <option value="reduced">Launch</option>
          </select>
        </div>

        <div class="field">
          <label>Target</label>
          <select class="ui fluid dropdown">
            <option value="">Target</option>
            <option value="early">Small</option>
            <option value="post-revenue">Mid</option>
          </select>
        </div>

        <div class="field">
          <label>Category</label>
          <select class="ui fluid dropdown">
            <option value="">Category</option>
            <option value="early">Investor</option>
            <option value="post-revenue">Association</option>
          </select>
        </div>

        <div class="field">
          <label>Enabler</label>
          <select class="ui fluid dropdown">
            <option value="">Enabler</option>
            <option value="T">Financial</option>
            <option value="I">Environment</option>
          </select>
        </div>
      </form>
        <!--
        <div class="ui vertical menu">
        <div class="item">
          <div class="header">Products</div>
          <div class="menu">
            <a class="item">Enterprise</a>
            <a class="item">Consumer</a>
          </div>
        </div>
        </div>
        -->
    </div>
    <div class="ui stackable ten wide column">
        <div id="app">
          <bars
            :data="[1, 10, 3, 5, 8, 12, 5]"
            :gradient="['#ffbe88', '#ff93df']"
            :barWidth="40"
            :growDuration="1">
          </bars>
        </div>
      <div class="ui horizontal divider"></div>
      <div>
        <h2>Matching Providers</h2>
        <div class="ui link cards">
        <?php foreach ($data as $k => $dat): ?>
          <div class="card">
              <div class="image">
                <!-- <img src="/images/avatar2/large/matthew.png"> -->
              </div>
              <div class="content">
                <div class="header"><?php echo $dat->name; ?></div>
                <div class="meta">
                  <a>Service Provider</a>
                </div>
                <div class="description">
                  <?php echo substr($dat->about, 0, 60); ?>
                </div>
              </div>
              <div class="extra content">
                <?php if( !empty($dat->yearsInOakland)): ?>
                <span class="right floated">
                  <?php echo $dat->yearsInOakland; ?> Years in Oakland
                </span>
                <?php endif?>
                <span>
                  <i class="linkedin icon"></i>
                  <i class="twitter icon"></i>
                  <i class="world icon"></i>
                </span>
              </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>



  <div class="ui inverted vertical footer segment">
    <div class="ui center aligned container">
      <div class="ui stackable inverted divided grid">
        <div class="three wide column">
          <h4 class="ui inverted header">Group 1</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Group 2</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Group 3</h4>
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
        </div>
        <div class="seven wide column">
          <h4 class="ui inverted header">Footer Header</h4>
          <p>Extra space for a call to action inside the footer that could help re-engage users.</p>
        </div>
      </div>
      <div class="ui inverted section divider"></div>
      <!-- <img src="assets/images/logo.png" class="ui centered mini image"> -->
      <div class="ui horizontal inverted small divided link list">
        <a class="item" href="#">Site Map</a>
        <a class="item" href="#">Contact Us</a>
        <a class="item" href="#">Terms and Conditions</a>
        <a class="item" href="#">Privacy Policy</a>
      </div>
    </div>
  </div>
</body>
<script src="/assets/jquery.min.js"></script>
<script src="/assets/semantic.min.js"></script>
<script>
  $('select.dropdown').dropdown();

  new Vue({ el: '#app' });
</script>
</html>
