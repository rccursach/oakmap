<?php
$data_read = file_get_contents('./data/data.oaktown.v1.json');
$data = json_decode($data_read); //var_dump( count($data) );

?><!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link href="https://daks2k3a4ib2z.cloudfront.net/57966ac4a71421564bb4e66d/5835034b4c49fcf420658dab_oak-st-fav-32.png" rel="shortcut icon" type="image/x-icon">
  <link href="https://daks2k3a4ib2z.cloudfront.net/57966ac4a71421564bb4e66d/583503516f1a34017488280e_oak-st-fav.png" rel="apple-touch-icon">
  <!-- Site Properties -->
  <title>Oakland Tech Ecosystem Map</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
  <script src=//unpkg.com/vue@2.5.9/dist/vue.min.js></script>
  <script src=//unpkg.com/vuebars@0.1.1/dist/vue-bars.min.js></script>

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

<div class="ui stackable responsive padded grid main container">
  <div class="row">
    <div class="four wide column">
      
      <form class="ui form">
        <h4 class="ui dividing header">Find a good fit:</h4>
        <div class="field">
          <div class="ui icon input">
            <i class="search icon"></i>
            <input type="text" id="search_name" placeholder="Search...">
          </div>
        </div>

        <div class="field">
          <label>Stage</label>
          <select class="ui fluid dropdown" id="search_stage">
            <option value=""></option>
            <option value="inspire">Inspire</option>
            <option value="plan">Plan</option>
            <option value="launch">Launch</option>
            <option value="sustain">Sustain</option>
            <option value="grow">Grow</option>
            <option value="exit">Exit</option>
          </select>
        </div>

        <div class="field">
          <label>Target</label>
          <select class="ui fluid dropdown" id="search_target">
            <option value=""></option>
            <option value="small">Small</option>
            <option value="mid">Mid</option>
            <option value="high">High</option>
            <option value="all">All</option>
          </select>
        </div>

        <div class="field">
          <label>Category</label>
          <select class="ui fluid dropdown" id="search_category">
            <option value=""></option>
            <option value="educationalInstitution">Educational Institution</option>
            <option value="ServiceProvider">Service Provider</option>
            <option value="Investor">Investor</option>
            <option value="Government">Government</option>
            <option value="Lender">Lender</option>
            <option value="Association">Association</option>
            <option value="Foundation">Foundation</option>
          </select>
        </div>

        <div class="field">
          <label>Enabler <i class="grey icon help" id="help_enabler"></i></label>
          <select class="ui fluid dropdown" id="search_enabler">
            <option value=""></option>
            <option value="personal">Personal</option>
            <option value="financial">Financial</option>
            <option value="business">Business</option>
            <option value="environment">Environment</option>
          </select>
        </div>

        <div class="ui basic modal">
          <div class="ui icon header">
            <i class="archive icon"></i>
            Enablers
          </div>
          <div class="content">
            <h1 class="header">Enablers can be viewed with the following lenses:</h1>
            <div class="ui huge middle aligned animated list">
              <div class="item">PERSONAL enablers (mentors, education, etc.)</div>
              <div class="item">FINANCIAL enablers (banks, investors, micro-finance, etc.)</div>
              <div class="item">BUSINESS enablers (incubators, networking associations, etc.)</div>
              <div class="item">ENVIRONMENT enablers (regulatory framework, infrastructure, culture, etc.)</div>
            </div>
          </div>
          <div class="actions">
            <div class="ui green ok inverted button">
              <i class="checkmark icon"></i>
              OK
            </div>
          </div>
        </div>

        <div class="field">
          <button class="fluid ui black basic right floated button" id="search_button">Find a Fit</button>
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
    <div class="ui stackable twelve wide column">
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
        <h2>Matching Providers <span id="match_count" class="ui teal header"></span></h2>
        <div class="ui three doubling cards">
        <?php foreach ($data as $k => $dat): ?>
          <?php 
            //var_dump($dat->subcategory);
          ?>
          <br/>     
          <div class="ui fluid <?php
            if(in_array('personal',$dat->enablerType)){
              echo 'purple';
            }elseif(in_array('financial',$dat->enablerType)){
              echo 'red';
            }elseif(in_array('business',$dat->enablerType)){
              echo 'blue';
            }elseif(in_array('environmental',$dat->enablerType)){
              echo 'green';
            }
            ?> card"
            data-name="<?php echo strtolower($dat->name); ?>"
            data-stage="<?php echo strtolower(implode(' ', $dat->stage)); ?>"
            data-target="<?php echo strtolower($dat->target); ?>"
            data-category="<?php echo strtolower(str_replace(' ','',$dat->category)); ?>"
            data-enabler="<?php echo strtolower(implode(' ', $dat->enablerType)); ?>"
          >
              <!-- 
              <div class="image">
                <img src="/images/avatar2/large/matthew.png"> 
              </div>
              -->
              <div class="content">
                <div class="header"><?php echo $dat->name; ?></div>
                <div class="meta">
                  <span class="category"><?php if($dat->category) echo ucwords($dat->category); ?><?php if($dat->subcategory) echo ': ' . ucwords($dat->subcategory); ?></span>
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
                <?php endif; ?>
                <span>
                  <?php if( !empty($dat->website)): ?>
                    <a href="<?php echo $dat->website; ?>"><i class="world icon"></i></a>
                  <?php endif; ?>
                  <?php if( !empty($dat->twitter)): ?>
                    <a href="https://twitter.com/<?php echo $dat->twitter; ?>"><i class="twitter icon"></i></a>
                  <?php endif; ?>
                  <?php if( !empty($dat->address)): ?>
                    <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($dat->address); ?>"><i class="map icon"></i></a>
                  <?php endif; ?>
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
          <!-- 
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
          -->
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Group 2</h4>
          <!-- 
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
          -->
        </div>
        <div class="three wide column">
          <h4 class="ui inverted header">Group 3</h4>
          <!--
          <div class="ui inverted link list">
            <a href="#" class="item">Link One</a>
            <a href="#" class="item">Link Two</a>
            <a href="#" class="item">Link Three</a>
            <a href="#" class="item">Link Four</a>
          </div>
          -->
        </div>
        <div class="seven wide column">
          <h4 class="ui inverted header">Oakland Tech Ecosystem</h4>
          <p>A project of the Oakland Startup Network and the Alliance for Community Development</p>
        </div>
      </div>
      <div class="ui inverted section divider"></div>
      <!-- <img src="assets/images/logo.png" class="ui centered mini image"> 
      <div class="ui horizontal inverted small divided link list">
        <a class="item" href="#">Site Map</a>
        <a class="item" href="#">Contact Us</a>
        <a class="item" href="#">Terms and Conditions</a>
        <a class="item" href="#">Privacy Policy</a>
      </div>
      -->
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
<script>
  //keep for now
  new Vue({ el: '#app' });

  $(function() {
    //initialize
    $('select.dropdown').dropdown();
    $('#match_count').text( $('div.card').length );

    $('#help_enabler').on( "click", function(event) {
      $('.ui.basic.modal').modal('show');
    });

    //search filters
    $('#search_button' ).on( "click", function(event) {
      event.preventDefault();
      $( "div.cards div.card" ).show();

      //set variables
      var filters = [];
      filters.search_name     = $("#search_name").val().toLowerCase();
      filters.search_stage    = $("#search_stage").val().toLowerCase();
      filters.search_target   = $("#search_target").val().toLowerCase();
      filters.search_category = $("#search_category").val().toLowerCase();
      filters.search_enabler  = $("#search_enabler").val().toLowerCase();
      console.log( filters );

      //simple filter
      $( "div.cards div.card" ).each(function(index){
        //filter on name
        if(filters.search_name !='') {
          $( this ).not( "[data-name *='"+ filters.search_name +"']" ).hide();
        }
        //filter on stage
        if(filters.search_stage !='') {
          $( this ).not( "[data-stage *= '"+ filters.search_stage +"']" ).hide();
        }
        //filter on target
        if(filters.search_target !='') {
          $( this ).not( "[data-target ='"+ filters.search_target +"']" ).hide();
        }
        //filter on category
        if(filters.search_category !='') {
          $( this ).not( "[data-category='"+ filters.search_category +"']" ).hide();
        }
        //filter on enabler
        if(filters.search_enabler !='') {
          $( this ).not( "[data-enabler *='"+ filters.search_enabler +"']" ).hide();
        }
      });

      //reset count
      $('#match_count').text( $('div.card:visible').length );
      $("div.card:visible").transition('pulse');
    });
  });
</script>
</html>
