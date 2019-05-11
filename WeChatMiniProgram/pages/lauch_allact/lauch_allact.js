// pages/lauch_allact/lauch_allact.js
Page({

  data: {

  },
  onLoad: function(options) {

  },
  onReady: function() {

  },

  OnLauch_act: function() {
    wx.navigateTo({
      url: '../lauch_act/lauch_act',
    })
  },
  Onscreen_and_informTap:function(){
    wx.navigateTo({
      url: '../screen_and_inform/screen_and_inform',
    })
  }

})