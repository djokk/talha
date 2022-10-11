<template>
  <div class="loader-overlay">
    <!-- <div class="loader-overlay-div"> -->
      <div class="spinner"></div>

    <!-- </div> -->
  </div>
</template>

<style>
.loader-overlay {
  width: 100%;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  background: rgba(75, 75, 75, 0.671);
  z-index: 97;
}
.spinner {
  /* position: absolute; */
  width: 60px;
  height: 60px;
  /* margin: 0px auto; */
  -webkit-animation: rotation 1s infinite linear;
  -moz-animation: rotation 1s infinite linear;
  -o-animation: rotation 1s infinite linear;
  animation: rotation 1s infinite linear;
  border-left: 6px solid rgba(165, 165, 165, 0.75);
  border-right: 6px solid rgba(165, 165, 165, 0.75);
  border-bottom: 6px solid rgba(165, 165, 165, 0.75);
  border-top: 6px solid rgba(255, 255, 255, 1);
  border-radius: 100%;
  z-index: 99;
}
@-webkit-keyframes rotation {
  from {-webkit-transform: rotate(0deg);}
  to {-webkit-transform: rotate(359deg);}
}
@-moz-keyframes rotation {
  from {-moz-transform: rotate(0deg);}
  to {-moz-transform: rotate(359deg);}
}
@-o-keyframes rotation {
  from {-o-transform: rotate(0deg);}
  to {-o-transform: rotate(359deg);}
}
@keyframes rotation {
  from {transform: rotate(0deg);}
  to {transform: rotate(359deg);}
}
</style>