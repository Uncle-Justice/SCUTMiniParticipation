import {
  Post
} from 'post-model.js';

var post = new Post();
const app = getApp();
Page({

  data: {
    'posts_key': {}
  },

  onLoad: function(options) {
    // this._loadData();
  },



  _loadData: function() {
    var count_act = 9;
    post.getPostData(count_act,
      (res) => {
        console.log(res);
        this.setData({
          'posts_key': res,
        })
      })
  },

  onShow: function(options) {
    this._loadData();
    // console.log('我调用了哈哈哈 ')
  },


  onPostTap: function(event) {
    var that = this;
    var closed = event.currentTarget.dataset.closed;
    if (closed == 0) {
      var questionnaire = event.currentTarget.dataset.questionnaire;
      let obj = JSON.stringify(questionnaire);

      var image = event.currentTarget.dataset.item.image
      var act_name = event.currentTarget.dataset.item.name
      wx.navigateTo({
        url: '../questionnarie/questionnarie?q=' + obj + '&image=' + image + '&act_name=' + act_name,
        success: function(res) {},
        fail: function(res) {},
        complete: function(res) {},
      })
    } else {
      wx.showToast({
        title: "该活动已截止",
        duration: 2000,
        icon: 'none'
      })
    }

  },


  onReady: function() {

  },
  onShareAppMessage: function(options) {
    app._onShareAppMessage(options)
  }
})