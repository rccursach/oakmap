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
          <label>Enabler <i class="grey icon help" id="help_enabler" v-on:click="showEnablerModal()" ></i></label>
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
          <button class="fluid ui black basic right floated button" id="search_button" v-on:click.prevent="filterCards()">Find a Fit</button>
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
        <h2>Matching Providers <span id="match_count" class="ui teal header">{{cards}}</span></h2>
        
        <div class="ui three doubling cards">
          <br/>
          <div v-for="dat in data" :key="dat.id"
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
              <div class="header">{{ dat.name }}</div>
              <div class="meta">
                <span class="category">{{ dat.category | capitalize }}
                  {{ (dat.subcategory ? ': '+dat.subcategory : '') | capitalize }}
                </span>
              </div>
              <div class="description">
                {{ dat.about | truncate(60) }}
              </div>
            </div>
            <div class="extra content">

              <span v-if="!!dat.yearsInOakland" class="right floated">
                {{ dat.yearsInOakland }} Years in Oakland
              </span>
              <span>
                <a v-if="!!dat.website" :href="dat.website"><i class="world icon"></i></a>
                <a v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="twitter icon"></i></a>
                <a v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="map icon"></i></a>
              </span>
            </div>
          </div>
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
      cards: 0,
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
      window.$.get('data/data.oaktown.v1.json', (d) => {
        // console.log(d)
        this.data = d
      })
    },
    showEnablerModal () {
      window.$('.ui.basic.modal').modal('show')
    },
    filterCards () {
      var $ = window.$
      $('div.cards div.card').show()

      // set variables
      var filters = []
      filters.search_name = $('#search_name').val().toLowerCase()
      filters.search_stage = $('#search_stage').val().toLowerCase()
      filters.search_target = $('#search_target').val().toLowerCase()
      filters.search_category = $('#search_category').val().toLowerCase()
      filters.search_enabler = $('#search_enabler').val().toLowerCase()

      console.log(filters)

      // simple filter
      $('div.cards div.card').each(function (index) {
        // filter on name
        if (filters.search_name !== '') {
          $(this).not(`[data-name *='${filters.search_name}']`).hide()
        }
        // filter on stage
        if (filters.search_stage !== '') {
          $(this).not(`[data-stage *= '${filters.search_stage}']`).hide()
        }
        // filter on target
        if (filters.search_target !== '') {
          $(this).not(`[data-target ='${filters.search_target}']`).hide()
        }
        // filter on category
        if (filters.search_category !== '') {
          $(this).not(`[data-category='${filters.search_category}']`).hide()
        }
        // filter on enabler
        if (filters.search_enabler !== '') {
          $(this).not(`[data-enabler *='${filters.search_enabler}']`).hide()
        }
      })

      // reset count
      $('#match_count').text($('div.card:visible').length)
      $('div .card:visible').transition('pulse')
    }
  },
  created: function () {
    this.loadData()
    var $ = window.$
    // initialize
    $('select.dropdown').dropdown()
    this.cards = $('div .card').length
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
  body {
    background-color: #FFFFFF;
  }
  .ui.menu .item img.logo {
    margin-right: 1.5em;
  }
  .main.container {
    margin-top: 3em;
  }
  .wireframe {
    margin-top: 2em;
  }
  .ui.footer.segment {
    margin: 5em 0em 0em;
    padding: 5em 0em;
  }
  #help_enabler {
    cursor: pointer;
  }
  #help_enabler:hover {
    -moz-transform: scale(1.15);
    -webkit-transform: scale(1.15);
    transform: scale(1.15);
  }
</style>
