import {
  Screen_and_inform
} from 'screen_and_inform-model.js';

var screen_and_inform = new Screen_and_inform();

Page({

  data: {
    'posts_key': {}
  },

  onLoad: function(options) {
    // this._loadData();
  },

  _loadData: function() {
    var count_act = 9;
    screen_and_inform.getPostData(count_act,
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

      wx.navigateTo({
        url: '../screen_and_inform_detail/screen_and_inform_detail?q=' + obj,
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

})