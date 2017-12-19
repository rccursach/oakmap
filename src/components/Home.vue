<template>
  <div>
<!--  -->
<div class="ui stackable responsive grid main container">
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
        
        <div class="ui three doubling cards" v-for="dat in data" :key="dat.id">
        <?php foreach ($data as $k => $dat): ?>
          <?php 
            //var_dump($dat->subcategory);
          ?>
          <br/>     
          <div
            :class="'ui fluid card ' + dat.enablerType.map(function (e) { return enClasses[e] }).join(' ')"
            :data-name="dat.name | lowercase"
            :data-target="dat.target | lowercase"
            :data-stage="dat.stage ? dat.stage.join(' ') : '' | lowercase"
            :data-category="dat.category ? dat.category.replace(' ', '') : '' | lowercase"
            :data-enabler="dat.enablerType ? dat.enablerType.join(' ') : '' | lowercase"
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
<!--  -->
  </div>
</template>

<script>
export default {
  name: 'Home',
  data () {
    return {
      data: [],
      enClasses: {
        personal: 'purple',
        financial: 'red',
        business: 'blue',
        environmental: 'green'
      }
    }
  },
  methods: {
    loadData () {
      window.$.get('../original_php/data/data.oaktown.v1.json', (data) => {
        this.data = data
      })
    }
  },
  created: function () {
    this.loadData()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
