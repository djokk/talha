<template>
  <section class="color">
    <div class="breadcrumb p-0">
      <router-link :to="{name: 'Stores'}" class="breadcrumb__link"><i class="bx bx-home-alt"></i></router-link>
      <div class="breadcrumb__item">
        <i class="fa fa-angle-right"></i>
        <p>{{ $t('history') }}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mb-3">
        <div class="filter-card">
          <div class="selects">
            <multiselect v-model="modelValue" select-label="" deselect-label="" placeholder="" :allow-empty="false" label="NameColor" track-by="Id" :options="modelOption" :multiple="false" :taggable="false" :searchable="false"></multiselect>
            <span>{{ $t('model') }}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="wrapper">
      <div class="card-custom">
        <div class="table-custom">
          <div class="table-custom__header">
            <p class="w-4">{{ $t('date') }}</p>
            <p class="w-1">{{ $t('modelCode') }}</p>
            <p class="w-2">{{ $t('modelName') }}</p>
            <p class="w-3">{{ $t('color') }}</p>
            <p class="w-5">{{ $t('count') }}</p>
            <p class="w-6">{{ $t('userName') }}</p>
          </div>
          <div class="table-custom__body">
            <div v-for="item in filteredList" :key="item.id" class="table-custom__body-item" :class="[ item.Parametrs == 1 ? 'bg-success' : 'bg-danger']">
              <span></span>
              <p class="w-4">{{ item.Dates }} {{ item.Times }}</p>
              <p class="w-1">{{ item.Code }}</p>
              <p class="w-2">{{ item.Name }}</p>
              <p class="w-3">{{ item.Color }} {{ item.ColorCode }}</p>
              <p class="w-5">{{ item.Counts }} ({{ item.Parametrs == 1 ? item.CountEnd : `-${item.CountEnd}` }})</p>
              <p class="w-6">{{ item.FullName }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Loading v-show="loading"/>
  </section>
</template>

<script>
import axios from 'axios';
import Loading from '@/components/Loading.vue';

export default {
  name: 'History',
  data() {
    return {
      loading: false,
      modelValue: {
        "Id": 0,
        "NameColor": 'All'
      },
      modelOption: [
        {
          "Id": 0,
          "NameColor": 'All'
        }
      ],
      info: [],
      token: '',
      api: '',
    }
  },
  components: {
    Loading
  },
  beforeMount() {
    this.api = window.MY_TALHA.api;
    // this.token = localStorage.token;
  },
  mounted() {
    // this.token = sessionStorage.getItem('token');
    
    const auth = JSON.parse(sessionStorage.getItem('auth'));
    if(auth == null || auth == undefined) {
      this.$router.push({ name: 'Auth' });
    }
    this.$i18n.locale = localStorage.local;
    this.getModel();
    this.getHistory();
  },
  computed: {
    filteredList() {
      if(this.info != []) {
        return this.info.filter(post => {
          if(this.modelValue.Id != 0) {
            return post.Code.toLowerCase().includes(this.modelValue.Code.toLowerCase())
          } else {
            return this.info;
          }
        })
      }
      return []
    }
  },
  methods: {
    getModel() {
      this.loading = true;
      this.modelOption = [
        {
          "Id": 0,
          "NameColor": 'All'
        }
      ];
      axios.get(`${this.api}/model`)
        .then(response => {
          for (let i = 0; i < response.data.length; i++) {
            this.modelOption.push({
              "Code": response.data[i].Code,
              "Color": response.data[i].Color,
              "ColorCode": response.data[i].ColorCode,
              "ColorId": +response.data[i].ColorId,
              "Id": +response.data[i].Id,
              "Name": response.data[i].Name,
              "NameColor": `${response.data[i].Name} ${response.data[i].Color}`
            });
          }
        })
        .catch(error => {
          console.log(error);
          this.$toast.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    getHistory() {
      this.loading = true;
      this.info = [];
      axios.get(`${this.api}/history`)
        .then(response => {
          this.info = response.data;
        })
        .catch(error => {
          console.log(error);
          this.$toast.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    }
  },
  watch: {
    // modelValue() {
    //   if(this.modelValue.Id == 0) {
    //     this.filteredList = this.info
    //   }
    // }
  }
}
</script>

<style lang="scss" scoped>
.color {
  @media screen and (max-width: 991.5px) {
    margin-left: 0;
    padding: 0px 10px;
  }
  .breadcrumb {
    display: flex;
    align-items: center;
    background-color: transparent;
    margin: 0px 0 25px;
    &__item {
      display: flex;
      align-items: center;
      .fa {
        color: #002f34;
        font-size: 25px;
        margin: 0 10px;
      }
      p {
        font-family: 'Roboto';
        font-size: 18px;
        line-height: 18px;
        font-weight: 500;
        color: #002f34;
      }
    }
    &__link {
      display: flex;
      align-items: center;
      .bx {
        color: #002f34;
        font-size: 26px;
      }
    }
  }
  .card-custom {
    // position: relative;
    // display: flex;
    // flex-direction: column;
    // min-width: 0;
    // word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid transparent;
    border-radius: 0.25rem;
    margin-bottom: 4.5rem;
    box-shadow: 0 0.3rem 0.8rem rgba(0,0,0,0.12);
    padding: 1rem;
    overflow: scroll hidden;
  }
  .table-custom {
    min-width: 1080px;
    // overflow: scroll hidden;
    &__header {
      display: flex;
      // justify-content: space-between;
      align-items: center;
      // padding: 0 0.5rem 1rem 0.5rem;
      p {
        font-size: 20px !important;
        font-weight: 600 !important;
        text-align: center;
        padding: 1rem;
      }
    }
    &__body {
      &-item {
        display: flex;
        transition: 0.3s all ease-in-out;
        min-height: 64px;
        padding: 0 0.5rem 0 0;
        position: relative;
        &:hover {
          background: rgba($color: #002f34, $alpha: 1) !important;
          p {
            color: #fff;
          }
        }
        &:nth-child(odd) {
          background: rgba($color: #002f34, $alpha: 0.12);
        }
        &:not(:last-child){
          border-bottom: 1px solid rgba($color: #002f34, $alpha: 0.15);
        }
        p {
          display: flex;
          justify-content: center;
          align-items: center;
          // padding: 0.5rem 0.5rem;
          color: #fff !important;
        }
        .btns {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding-left: 0.5rem;
          .btn {
            display: block;
            padding: 0.375rem 0.75rem;
          }
        }
        .w-2 {
          border-left: 1px solid rgba(255, 255, 255, 0.15);
          border-right: 1px solid rgba(255, 255, 255, 0.15);
        }
        .w-4 {
          border-left: 1px solid rgba(255, 255, 255, 0.15);
        }
      }
    }
    p {
      font-family: 'Roboto';
      font-size: 16px;
      line-height: 16px;
      font-weight: 400;
      color: rgba($color: #002f34, $alpha: 0.85);
      word-break: break-all;
      white-space: pre-wrap;
    }
    .w-1 {
      width: calc(100%/6);
    }
    .w-2 {
      width: calc(100%/6);
    }
    .w-3 {
      width: calc(100%/6);
    }
    .w-4 {
      width: calc(100%/6);
    }
    .w-5 {
      width: calc(100%/6);
    }
    .w-6 {
      width: calc(100%/6);
    }
  }
  .filter-card {
    // display: flex;
    // justify-content: space-between;
    // align-items: center;
    background-color: #fff;
    transition: all .5s ease-in-out;
    position: relative;
    border: 0rem solid transparent;
    border-radius: 1.25rem;
    box-shadow: 0rem 0.3125rem 0.3125rem 0rem rgba(43, 37, 51, 0.05);
    padding: 15px;
    .selects {
      // background: #fff;
      .multiselect {
        cursor: pointer;
        border: 2px solid rgba(0,0,0,.12);
        border-radius: 5px;
        // margin-bottom: 12px;
        padding: 2px 0;
        font-family: 'Roboto';
        &:hover {
          border-color: rgb(175, 175, 175);
          transition: 0.3s all ease-in-out;
        }
      }
      .multiselect__single {
        font-family: 'Roboto';
      }
      span {
        padding: 2px 5px 0 5px !important;
        margin-bottom: 2px;
        z-index: 10;
      }
      .multiselect:hover+span {
        color: rgb(175, 175, 175);
        transition: 0.3s all ease-in-out;
      }
      .multiselect .multiselect__tags {
        background: transparent !important;
      }
    }
  }
  .name,
  .selects,
  .number,
  .databasePassword,
  .search {
    position: relative;
    span {
      position: absolute;
      z-index: 2;
      top: 0%;
      left: 10px;
      transform: translateY(-50%);
      font-family: 'Roboto';
      font-size: 12px;
      font-weight: 400;
      color: rgba(0,0,0,.4);
      background: #fff;
      padding: 2px 5px;
    }
  }
  .input {
    width: 100%;
    font-family: 'Roboto';
    font-size: 18px;
    font-weight: 400;
    color: #5A5A5A;
    border: 2px solid rgba(0,0,0,.12);
    border-radius: 5px;
    padding: 0.5em 0.7em;
    position: relative;
    background: transparent;
    z-index: 1;
    margin: 0;
    &:hover {
      border-color: rgb(175, 175, 175);
      transition: 0.3s all ease-in-out;
    }
    &:focus-visible {
      border-color: rgb(175, 175, 175);
      outline: none;
    }
  }
  input:focus-visible+span{
    transition: 0.3s all ease-in-out;
    color: rgb(175, 175, 175) !important;
  }
  input:hover+span{
    transition: 0.3s all ease-in-out;
    color: rgb(175, 175, 175);
  }
}
</style>