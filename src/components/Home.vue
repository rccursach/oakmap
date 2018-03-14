<template>
  <div>
    <!--  -->
    <div class="container">
      <div class="up-button is-hidden-desktop " v-on:click.prevent="scrollToTop" aria-role="presentation">
        <i class="fa fa-arrow-up"></i>
      </div>
      
      <div class="columns">
        <div class="column is-banner">
          <h2 id="matched-providers" tabindex="0" class="title is-size-4 has-text-white">Matching Providers <span class="xcards-match">{{cards}} </span></h2>
          <!-- <button aria-role="button" tabindex="0" class="button is-rounded is-info xis-outlined" v-on:click.prevent="showNlf">Find a fit</button> -->
        </div>
      </div>

      <!-- sidebar -->
      <div class="columns">
        <div class="column is-one-quarter">
          <!-- tabs -->
          <div class="tabs">
            <ul id="sidebar-tabs">
              <li class="is-active" v-on:click.prevent="setTab('explore')"><a>Explore</a></li>
              <li v-on:click.prevent="setTab('filter')"><a>Filter</a></li>
            </ul>
          </div>
          <!-- contents -->
          <div style="overflow-y: auto; height: 450px;">
            <sidebar v-if="this.tab === 'explore'"></sidebar>
            <filter-form
              v-if="this.tab === 'filter'"
              :map-data="mapData.data"
              @map-filtered="countCards">
            </filter-form>
          </div>
        </div>

        <!-- viz -->
        <div class="column">
          <viz :data="mapData.data" :links="mapData.links"></viz>
        </div>
      </div>

      <hr>

      <div class="columns">
        <cards :map-data="stakeholders"></cards>
      </div>

    </div>
    <!--  -->
  </div>
</template>

<script>
import axios from 'axios'
import viz from './Viz'
import cards from './Cards'
import filterForm from './FilterForm'
import sidebar from './SideBar'
import { EventBus } from '../event-bus.js'

export default {
  name: 'Home',
  components: {
    viz,
    cards,
    filterForm,
    sidebar
  },
  data () {
    return {
      mapData: {
        data: [],
        links: []
      },
      tab: 'explore',
      stakeholders: [],
      cards: 0
    }
  },
  methods: {
    setTab (name) {
      document.querySelectorAll('#sidebar-tabs li')
      .forEach(a => {
        if (a.classList.contains('is-active')) {
          a.classList.remove('is-active')
        }
        if (a.querySelector('a').text && a.querySelector('a').text.toLowerCase() === name) {
          a.classList.add('is-active')
          this.tab = name
        }
      })
    },
    loadData () {
      axios.get('data/data.json').then(
        res => {
          this.mapData = res.data
          this.stakeholders = []
          this.mapData.data.forEach(d => {
            if (d.type === 'sh') {
              d.hidden = false
              this.stakeholders.push(d)
            }
            console.log(d)
          })
          this.countCards()
        },
        error => {
          console.log(error)
        }
      )
      EventBus.$emit('updated-data', 'ok')
    },
    scrollToTop () {
      window.scrollTo(0, 0)
    },
    countCards () {
      const reducer = function (n, o) {
        if (o.type === 'sh') {
          return n + (o.hidden === false ? 1 : 0)
        } else {
          return 0
        }
      }
      this.cards = this.stakeholders.reduce(reducer, 0)
    }
  },
  watch: {
    // mapData: function (newMapData) {
    //   this.countCards()
    // }
  },
  created: function () {
    this.loadData()
    let _vm = this
    EventBus.$on('filtered-data', function (i) {
      _vm.setTab('explore')
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.is-banner {
  background: linear-gradient(41deg, #ec95c8 0%, #dfa8bb 31%, #ffbe88 75%);
  margin-top: 1.5em;
  left: 0;
  right: 0;
}

.up-button {
  cursor: pointer;
  display: block;
  position: fixed;
  z-index: 100;
  right: 1em;
  bottom: 2em;
  height: 3em;
  width: 3em;
  border-radius: 1.5em;
  text-align: center;
  background-color: #d25ca133;
  color: #d25ca199;
  /* border: 1px solid #d25ca199; */
}
.up-button:hover {
  border: 0;
  background-color: #d25ca199;
  color: white;
}

.modal {
  z-index: 101;
}

#main-container {
  padding: 0 0.5em
}
</style>
