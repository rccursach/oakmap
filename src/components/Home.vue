<template>
  <div>
    <!--  -->
    <div class="container">
    <div class="up-button is-hidden-desktop " v-on:click.prevent="scrollToTop" aria-role="presentation">
      <i class="fa fa-arrow-up"></i>
    </div>
      <div class="columns" id="main-container">
        <div class="column">

          <div class="columns">
            <div class="column is-one-quarter">
              <filter-form :map-data="mapData" @map-filtered="countCards"></filter-form>
            </div>
            <div class="column">
              <div class="column is-banner">
                <h2 id="matched-providers" tabindex="0" class="title is-size-4 has-text-white">Matching Providers <span class="xcards-match">{{cards}} </span></h2>
                <!-- <button aria-role="button" tabindex="0" class="button is-rounded is-info xis-outlined" v-on:click.prevent="showNlf">Find a fit</button> -->
              </div>
              <viz :map-data="mapData"></viz>
            </div>
          </div>
         
          <cards :map-data="mapData"></cards>

        </div> <!-- end column -->

      </div><!-- end columns -->
    </div>
    <!--  -->
  </div>
</template>

<script>
import axios from 'axios'
import viz from './Viz'
import cards from './Cards'
import filterForm from './FilterForm'

export default {
  name: 'Home',
  components: {
    viz,
    cards,
    filterForm
  },
  data () {
    return {
      mapData: [],
      cards: 0
    }
  },
  methods: {
    loadData () {
      axios.get('data/data.oaktown.v1.json').then(
        d => {
          var values = Object.values(d.data)
          this.mapData = values.map(md => {
            md.hide = false
            return md
          })
          window.d = this.mapData
          this.cards = this.mapData.length
        },
        error => {
          console.log(error)
        }
      )
    },
    scrollToTop () {
      window.scrollTo(0, 0)
    },
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
    }
  },
  watch: {
    mapData: function (newMapData) {
      this.countCards()
    }
  },
  created: function () {
    this.loadData()
    this.cards = this.mapData.length
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

.is-banner {
  background: linear-gradient(41deg, #ec95c8 0%, #dfa8bb 31%, #ffbe88 75%);
  margin: 3em 0.8em 1.5em 0.8em;
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
