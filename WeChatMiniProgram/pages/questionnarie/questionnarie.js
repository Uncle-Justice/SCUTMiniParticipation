// pages/questionnarie/questionnarie.js
import WxValidate from '../../utils/classes/WxValidate.js'
var validate;

var baseUrl = 'https://uncle-justice.top/zerg/public/index.php/api/v1';

Page({
  initValidate() {
    // 创建实例对象
    //构造函数传参数，第一个参数传rule，第二个参数传message
    //数组元素的顺序就是判断的顺序
    if (this.data.questionnaire.student_id) {
      var student_id = {
        required: true,
        maxlength: 12,
        minlength: 12
      }
    }
    if (this.data.questionnaire.institute) {
      var institute = {
        required: true,
      }
    }
    if (this.data.questionnaire.gender) {
      var gender = {
        required: true
      }
    }
    if (this.data.questionnaire.campus) {
      var campus = {
        required: true
      }
    }
    if (this.data.questionnaire.grade) {
      var grade = {
        required: true
      }
    }
    if (this.data.questionnaire.user_name) {
      var name = {
        required: true
      }
    }

    if (this.data.questionnaire.telephone) {
      var telephone = {
        required: true,
        tel: true
      }
    }


    this.validate = new WxValidate({
      name,
      gender,
      campus,
      institute,
      grade,
      student_id,
      telephone
    }, {
      name: {
        required: '请输入你的姓名',
      },
      gender: {
        required: '请选择你的性别',
      },
      campus: {
        required: '请选择你的校区',
      },
      institute: {
        required: '请输入你的学院',
      },
      grade: {
        required: '请输入你的年级',
      },
      student_id: {
        required: '请输入你的学号',
        maxlength: '学号应该为12位数字',
        minlength: '学号应该为12位数字'
      },
      telephone: {
        required: '请输入你的联系电话',
        tel: '请输入符合手机号码格式的11位的手机号码'
      }


    })
  },






  data: {
    'batch_items': {
      batch_item1: null,
      batch_item2: null,
      batch_item3: null,
      batch_item4: null,
      batch_item5: null,
      batch_item6: null,
      batch_item7: null,
      batch_item8: null,
    },
    'value': {},
    "questionnaire": ''
  },

  onLoad: function(options) {
    console.log(options)
    let item = JSON.parse(options.q);

    this._loadData(item);
    this._loadData2(options);
    this.initValidate();
  },

  _loadData: function(questionnaire) {
    var questionnaire = questionnaire;
    this.setData({
      'questionnaire': questionnaire,
    });
  },

  _loadData2: function(options) {
    var image = options.image;
    var act_name = options.act_name;
    this.setData({
      'image': image,
      'act_name': act_name,
    })
  },



  onReady: function() {

  },

  checkboxChange: function(event) {

  },

  //这里要用push 否则会重置掉我的q_id，然而我偷懒orz
  formSubmit: function(event) {

    if (!this.validate.checkForm(event.detail.value)) {
      const error = this.validate.errorList[0];
      wx.showToast({
        title: `${error.msg} `,
        icon: 'none',
        duration: 1500
      })
      return false
    }
    var that = this;
    var value = event.detail.value;

    if (value.batch_items)
      that.setData({
        'batch_items.batch_item1': value.batch_items[0],
        'batch_items.batch_item2': value.batch_items[1],
        'batch_items.batch_item3': value.batch_items[2],
        'batch_items.batch_item4': value.batch_items[3],
        'batch_items.batch_item5': value.batch_items[4],
        'batch_items.batch_item6': value.batch_items[5],
        'batch_items.batch_item7': value.batch_items[6],
        'batch_items.batch_item8': value.batch_items[7],
        // 'batch_items':value.batch_items
      })


    this.setData({
      'value': value,
      'value.questionnaire_id': this.data.questionnaire.id,
      'value.batch_items': this.data.batch_items,

    })
    this.submitData();
  },

  formReset: function(event) {
    console.log('重置成功')
  },


  submitData: function() {
    var that = this;
    var created = that.data.questionnaire.created;

    if (created == 0) {
      that._submitdata();
    } else {
      wx.showModal({
        title: '',
        content: '同一微信用户重复报名将修改上一次已提交的问卷，请问是否继续',
        success: function(res) {
          if (res.confirm) {
            that._submitdata();
          }
        }
      })
    }
  },

  _submitdata: function() {
    var token = wx.getStorageSync('token');
    wx.request({
      url: baseUrl + '/userquestionnaire',
      header: {
        token: token
      },
      data: {
        'value': this.data.value
      },
      method: 'POST',
      success: function(res) {
        wx.navigateBack({
          success: function(res) {
            wx.showToast({
              title: "提交成功",
              duration: 1500,
              icon: "success",
            })
          }
        })
      },
      fail: function(res) {
        console.log('提交失败');
      }
    })
  }
})