import {
  My_apply
} from 'my_apply-model.js';
var my_apply = new My_apply();

const app = getApp(); //得到全局变量 用于显示TAB栏目通知的数字

Page({
  data: {

  },

  onShow: function(options) {
    this._loadData();
  },

  onLoad: function(options) {
    this._loadData();
  },

  _loadData: function() {

    my_apply.getPostData(
      (res) => {
        // console.log(res);
        this.setData({
          'posts_key': res,
        })
      })

    my_apply.getInformData(
      (res) => {
        // console.log(res);
        this.setData({
          'totalNoreadNum': res.total,
        })
        var totalNoreadNum = this.data.totalNoreadNum;
        app._showNoreadNum(totalNoreadNum);
      })

  },

  onPostTap: function(event) {

    var q = event.currentTarget.dataset.questionnaire.questionnaire;
    let obj = JSON.stringify(q);


    var user_inform = event.currentTarget.dataset.questionnaire;
    var obj2 = {
      'user_name': user_inform.name,
      'gender': user_inform.gender,
      'institute': user_inform.institute,
      'grade': user_inform.grade,
      'campus': user_inform.campus,
      'student_id': user_inform.student_id,
      'status': user_inform.status,
      'telephone': user_inform.telephone,

      'batch_item1': user_inform.batch_item1,
      'batch_item2': user_inform.batch_item2,
      'batch_item3': user_inform.batch_item3,
      'batch_item4': user_inform.batch_item4,
      'batch_item5': user_inform.batch_item5,
      'batch_item6': user_inform.batch_item6,
      'batch_item7': user_inform.batch_item7,
      'batch_item8': user_inform.batch_item8,
    }
    let obj_2 = JSON.stringify(obj2);


    wx.navigateTo({
      url: '../questionnaire-filled/questionnaire-filled?q=' + obj + '&u=' + obj_2,
      success: function(res) {},
      fail: function(res) {},
      complete: function(res) {},
    })
  },

  onReady: function() {

  },
  onShareAppMessage: function (options) {
    app._onShareAppMessage(options)
  }
})