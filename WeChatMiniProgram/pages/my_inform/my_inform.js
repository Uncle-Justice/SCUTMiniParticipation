import {
  My_inform
} from 'my_inform-model.js';
var my_inform = new My_inform();
const app = getApp();
Page({

  data: {},

  onLoad: function(options) {
    this._loadData();
  },

  onShow: function() {
    this._loadData();
    app.getToken();
  },

  // wx.setTabBarBadge({
  //   index: 2,
  //   text: this.data.NoreadNum
  // });

  onReady: function() {

  },

  _loadData: function() {
    var that = this;
    my_inform.getInformData(
      (res) => {
        console.log(res);
        this.setData({
          'inform_post': res,
          'totalNoreadNum': res.total,
        })
        var totalNoreadNum = this.data.totalNoreadNum;
        app._showNoreadNum(totalNoreadNum);

        var obj = that.data.inform_post
        var arr = Object.keys(obj);
        this.setData({
          'arr': arr
        })
      })

  },



  OnInformTap: function(event) {
    console.log(event.currentTarget.dataset);
    var id = event.currentTarget.dataset.id;
    var name = event.currentTarget.dataset.name;
    var notification = event.currentTarget.dataset.notification;
    var alreadyread = event.currentTarget.dataset.alreadyread;
    var updatetime = event.currentTarget.dataset.updatetime;
    var alreadyreadnum = event.currentTarget.dataset.alreadyreadnum;

    wx.navigateTo({
      url: '../my_inform_detail/my_inform_detail?id=' + id + "&name=" + name + "&notification=" + notification + "&alreadyread=" + alreadyread + "&updatetime=" + updatetime + "&alreadyreadnum=" + alreadyreadnum,
    })
  },

  onShareAppMessage: function(options) {
    app._onShareAppMessage(options)
  }
})