// pages/lauch_act/lauch_act.js
var baseUrl = 'https://uncle-justice.top/zerg/public/index.php/api/v1';
const app = getApp()

Page({

  bindPickerChange(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index: e.detail.value
    })

    for (var i = 0; i <= 7; i++) { //初始化
      var temp1 = 'batch[' + i + '].display'
      var temp2 = 'batch[' + i + '].hidden'


      this.setData({
        [temp1]: 0,
        [temp2]: 'ture',

      })

    }

    for (var i = 0; i <= e.detail.value; i++) {
      var temp1 = 'batch[' + i + '].display'
      var temp2 = 'batch[' + i + '].hidden'


      this.setData({
        [temp1]: 1,
        [temp2]: false,

      })

    }
  },

  bindPickerChange1(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      index1: e.detail.value
    })

    for (var i = 0; i <= 2; i++) { //初始化
      var temp1 = 'singleChoice[' + i + '].display'
      var temp2 = 'singleChoice[' + i + '].hidden'


      this.setData({
        [temp1]: 0,
        [temp2]: 'ture',

      })

    }

    for (var i = 0; i <= e.detail.value; i++) {
      var temp1 = 'singleChoice[' + i + '].display'
      var temp2 = 'singleChoice[' + i + '].hidden'


      this.setData({
        [temp1]: 1,
        [temp2]: false,

      })

    }
  },


  batchFill: function(e) {
    let index = 'batch[' + e.currentTarget.dataset.index + '].content'
    var value = e.detail.value
    this.setData({
      [index]: value
    })
  },

  limitFill: function(e) {
    let index = 'batch[' + e.currentTarget.dataset.index + '].limit'
    var value = e.detail.value
    this.setData({
      [index]: value
    })
  },

  singleChoiceFill: function(e) {
    let index = 'singleChoice[' + e.currentTarget.dataset.index + '].content'
    var value = e.detail.value
    this.setData({
      [index]: value
    })
  },



  onItemTap: function(event) {

    var that = this;
    console.log(event.currentTarget.dataset.item);
    var id = event.currentTarget.dataset.item;




    var temp = 'items[' + id + '].bool';


    if (this.data.items[id].bool == '0')
      that.setData({
          [temp]: 1
        }


      )
    else {
      that.setData({
        [temp]: 0
      })

    }

  },

  onSpecialTap(event) {
    var that = this;
    console.log(event.currentTarget.dataset.item);
    var id = event.currentTarget.dataset.item;




    var temp = 'special[' + id + '].bool';


    if (this.data.special[id].bool == '0')
      that.setData({
          [temp]: 1
        }


      )
    else {
      that.setData({
        [temp]: 0
      })

    }
    if (this.data.special[0].bool == '1') {
      var t1 = 'batch[' + 0 + '].hidden';
      var t2 = 'batch[' + 0 + '].display';
      that.setData({

        [t1]: false,
        [t2]: 1
      })



    }
    if (this.data.special[0].bool == '0') {
      for (var i = 0; i < 8; i++) {
        var t1 = 'batch[' + i + '].hidden';
        var t2 = 'batch[' + i + '].display';
        var t3 = 'batch[' + i + '].content';
        var t4 = 'batch[' + i + '].limit';
        that.setData({

          [t1]: true,
          [t2]: 0,
          [t3]: "",
          [t4]: '',
          index: 0,
        })
      }
    }
    if (this.data.special[1].bool == '1') {
      var t1 = 'singleChoice[' + 0 + '].hidden';
      var t2 = 'singleChoice[' + 0 + '].display';
      that.setData({

        [t1]: false,
        [t2]: 1
      })


    }

    if (this.data.special[1].bool == '0') {
      for (var i = 0; i < 3; i++) {
        var t1 = 'singleChoice[' + i + '].hidden';
        var t2 = 'singleChoice[' + i + '].display';
        var t3 = 'singleChoice[' + i + '].content';

        that.setData({

          [t1]: true,
          [t2]: 0,
          [t3]: "",
          index1: 0
        })
      }
    }

  },


  bindDateChange(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      date: e.detail.value
    })
  },
  bindTimeChange(e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    this.setData({
      time: e.detail.value
    })
  },



  isEmpty: function(obj) {
    if (typeof obj == "undefined" || obj == null || obj == "") {
      return true;
    } else {
      return false;
    }
  },

  functiontransdate(d, t) {
    var date = new Date();
    date.setFullYear(d.substring(0, 4));
    date.setMonth(d.substring(5, 7) - 1);
    date.setDate(d.substring(8, 10));
    date.setHours(t.substring(0, 2));
    date.setMinutes(t.substring(3, 5));
    date.setSeconds('00');
    return Date.parse(date) / 1000;
  },


  formSubmit: function(event)
   {
     var that=this;
    var token = wx.getStorageSync('token');

    var value = event.detail.value;
    console.log(value);

    if (this.isEmpty(value.projectTitle) || this.isEmpty(value.projectIntro) || this.isEmpty(value.questionnaire_des) || this.isEmpty(value.questionnaire_name)) {
      wx.showToast({
        title: "有未填入的信息",
        duration: 1500,
        image: '/imgs/icon/pay@error.png',
      })
      return false;
    }



    var activity = {
      name: value.projectTitle,

      description: value.projectIntro,

     image:"image1",

    }


    var questionnaire = {
      description: value.questionnaire_des,

      name: value.questionnaire_name,

      user_name: this.data.items[0].bool,

      gender: this.data.items[1].bool,


      institute: this.data.items[2].bool,


      grade: this.data.items[3].bool,


      campus: this.data.items[4].bool,


      student_id: this.data.items[5].bool,

      telephone: this.data.items[6].bool,

      batch: this.data.special[0].bool,

      // singChoice: this.data.items[7].bool,

      deadline: this.functiontransdate(this.data.date, this.data.time),

      // image:"",

    }



    for (var i = 0; i < 8; ++i) 
    {
      var x = i + 1
      var s = 'batch_item' + x
      var t = 'batch_item_limit' + x


      if (this.data.batch[i].display=='1') {
        if (this.isEmpty(this.data.batch[i].content))


        {
          wx.showToast({
            title: "有未填入的信息",
            duration: 1500,
            image: '/imgs/icon/pay@error.png',
          })
          return false;
        }


        questionnaire[s] = this.data.batch[i].content
        questionnaire[t] = this.data.batch[i].limit
      }

    }

    for (var i = 0; i < 3; ++i) 
    {
      var x = i + 1
      var s = 'singChoice' + x


      if (this.data.singleChoice[i].display=='1')
      {
        if (this.isEmpty(this.data.singleChoice[i].content)) 
        {
          wx.showToast({
            title: "有未填入的信息",
            duration: 1500,
            image: '/imgs/icon/pay@error.png',
          })
          return false;
        }


        questionnaire[s] = this.data.singleChoice[i].content
      }
    }

    var count = 0;
    //上传文件
    for (var i = 0; i < this.data.tempFilePaths.length; i++) {
      wx.uploadFile({

        url: baseUrl + "/upload", //请求上传的url
        filePath: this.data.tempFilePaths[i],
        name: 'image',
        async: false,
        header: {
          "Content-Type": "multipart/form-data",
          token: token
        },

        success: function (res) {
          count++;
          //如果是最后一张,则隐藏等待中  
          if (count == that.data.tempFilePaths.length) {
            wx.hideToast();
          }
          // wx.showToast({
          //   title: '上传成功',
          //   icon: '',
          //   mask: true,
          //   duration: 1500
          // })
          // console.log(res);
          console.log(res);
          var t = res.data;
        
          
          activity['image'] = t.substring(4,49) ;
          // var s='image'
          // activity[s] = "image";
          var submitdata =
          {
            activity: activity,
            questionnaire: questionnaire
          }




          console.log('提交成功', value)
          that.setData({
            'activity': activity,
            'questionnaire': questionnaire,
            'value': value,
            'submitdata': submitdata,
          })
          // console.log(this.data.value);
          that.submitData();

        },
        fail: function (res) {
          wx.hideToast();
          wx.showModal({
            title: '错误提示',
            content: '上传图片失败',
            showCancel: false,
            success: function (res) { }
          })
        }
      });
    }


      // var submitdata = 
      // {
      //   activity: activity,
      //   questionnaire: questionnaire
      // }

   


      // console.log('提交成功', value)
      // this.setData({
      //   'activity': activity,
      //   'questionnaire': questionnaire,
      //   'value': value,
      //   'submitdata': submitdata,
      // })
      // console.log(this.data.value);
      // this.submitData();
    },
  

  
  
  formReset: function(event) {
    console.log('重置成功')
    for (var i = 0; i < 7; ++i) {

      var t = 'items[' + i + '].bool';

      this.setData({
        [t]: 0
      })

    }

    for (var i = 0; i < 2; ++i) {

      var t = 'special[' + i + '].bool';

      this.setData({
        [t]: 0
      })

    }
    this.setData({
      index: 0,
      index1: 0
    })

    for (var i = 0; i < 8; i++) {
      var t1 = 'batch[' + i + '].hidden';
      var t2 = 'batch[' + i + '].display';
      this.setData({
        // batch[0].display:
        [t1]: true,
        [t2]: 0
      })
    }
    for (var i = 0; i < 3; i++) {
      var t1 = 'singleChoice[' + i + '].hidden';
      var t2 = 'singleChoice[' + i + '].display';
      this.setData({

        [t1]: true,
        [t2]: 0
      })
    }
    this.setData({
      date: this.data.today,
      time: '00:00',
      // tempFilePaths[0]:''
    })


  },


  submitData: function() {
    var token = wx.getStorageSync('token');
    var that = this;
    wx.request({
      url: baseUrl + '/activity',
      header: {
        token: token
      },
      data: {


        'value': this.data.submitdata
        // 'activity': this.data.activity,
        // 'questionnaire': this.data.questionnaire





      },
      method: 'POST',
      success: function(res) {
        console.log(1);
        console.log(res.data);
        let t = res.data.msg;
        if(t=="success"){
          wx.showToast({
            title: "提交成功",
            duration: 1500,
            icon: "success",
          })
        }
        else if (t == "duplicate name")
        {
          wx.showToast({
            title: "请勿重复提交",
            duration: 1500,
            image: '/imgs/icon/pay@error.png',
          })
        }
      },
      fail: function(res) {
        console.log('提交失败');
        console.log(res.data);
      }

    })


  },


  /**
   * 页面的初始数据
   */
  data: {
    tempFilePaths: [],
    downloadPicturePath: '',
    date: '2016-09-01',
    time: '00:00',
    today: '',
    array1: ['1', '2', '3'], //单选
    objectArray1: [{
        id: 1,

      },

      {
        id: 2,

      },
      {
        id: 3,

      },


    ],
    index1: 0,
    array: ['1', '2', '3', '4', '5', '6', '7', '8'], //批次
    objectArray: [{
        id: 1,

      },

      {
        id: 2,

      },
      {
        id: 3,

      },
      {
        id: 4,

      },
      {
        id: 5,

      },
      {
        id: 6,

      },
      {
        id: 7,

      },
      {
        id: 8,

      },
    ],
    index: 0,
    // item:[{
    //     id:0,
    //     option:gender,
    //     value:0

    //   },
    //   {
    //     id: 1,
    //     option: institute,
    //     value: 0

    //   },
    //   {
    //     id: 2,
    //     option: grade,
    //     value: 0

    //   },
    //   {
    //     id: 3,
    //     option: campus,
    //     value: 0

    //   },
    //   {
    //     id: 4,
    //     option: student_id,
    //     value: 0

    //   },
    // ],

    'submitdata': {},
    'activity': {},
    'questionnaire': {},
    'value': {},

    // array: ['限制', '不限制'],
    // objectArray: [{
    //     id: 0,
    //     name: '限制'
    //   },
    //   {
    //     id: 1,
    //     name: '不限制'
    //   },

    // ],
    // index: 0,

    items: [
      // {
      //   name: 'name',
      //   value: '姓名'
      // },
      {
        name: 'name',
        value: '姓名',
        index: 0,
        bool: 0,

      },
      {
        name: 'gender',
        value: '性别',
        index: 1,
        bool: 0,

      },
      {
        name: 'institute',
        value: '学院',
        index: 2,
        bool: 0,
      },
      {
        name: 'grade',
        value: '年级',
        index: 3,
        bool: 0,
      },
      {
        name: 'campus',
        value: '校区',
        index: 4,
        bool: 0,
      },
      // {
      //   name: 'phone',
      //   value: '电话号码'
      // },
      {
        name: 'student_id',
        value: '学号',
        index: 5,
        bool: 0,
      },
      {
        name: 'telephone',
        value: '手机号码',
        index: 6,
        bool: 0,
      },

      // {
      //   name: 'batch',
      //   value: '是否有多个批次',
      //   index: 6,
      //   bool: 0,
      // },
      // {
      //   name: 'singleChoice',
      //   value: '是否需要单项选择题',
      //   index: 7,
      //   bool: 0,
      // },




      // {
      //   name: 'class',
      //   value: '班级'
      // },

    ],

    special: [{
        name: 'batch',
        value: '活动是否有多个批次',
        index: 0,
        bool: 0,
      },
      {
        name: 'singleChoice',
        value: '问卷是否需要单项选择题',
        index: 1,
        bool: 0,
      },
    ],

    batch: [{
        content: "",
        limit: "",
        hidden: true,

        display: "0",
        index: ""
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "1"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "2"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "3"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "4"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "5"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "6"
      },
      {
        content: "",
        limit: "",
        hidden: true,
        display: "0",
        index: "7"
      },


    ],

  

  singleChoice: [
    {
      content: "",
      hidden: true,
      display: "0",
      index: "0"
    },
    {
      content: "",
      hidden: true,
      display: "0",
      index: "1"
    },
    {
      content: "",
      hidden: true,
      display: "0",
      index: "2"
    },

  ],
  },
// upload:function(){
//   var token = wx.getStorageSync('token');
//   wx.chooseImage({
//     success(res) {
//       const tempFilePaths = res.tempFilePaths
//       wx.uploadFile({
//         url: baseUrl+'/upload', // 仅为示例，非真实的接口地址
//         filePath: tempFilePaths[0],
//         name: 'image',
//         header: {
//               "Content-Type": "multipart/form-data",
//               token:token
//             },
//         // formData: {
//         //   user: 'test'
//         // },
//         success(res) {
//           const data = res.data
//           // do something
//           console.log(data)
//         }
//       })
//     }
//   })
// },
  upload: function () {
    let that = this;
    var token = wx.getStorageSync('token');
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success: res => {
        // wx.showToast({
        //   title: '正在上传...',
        //   icon: 'loading',
        //   mask: true,
        //   duration: 1000
        // })
        // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
        let tempFilePaths = res.tempFilePaths;
        that.setData({
          tempFilePaths: tempFilePaths
        })
        /**
         * 上传完成后把文件上传到服务器
         */
        // var count = 0;
        // //上传文件
        // for (var i = 0; i < this.data.tempFilePaths.length; i++) {
        //   wx.uploadFile({
      
        //     url:baseUrl+ "/upload", //请求上传的url
        //     filePath: tempFilePaths[i],
        //     name: 'image',
        //     header: {
        //       "Content-Type": "multipart/form-data",
        //       token:token
        //     },
         
        //     success: function (res) {
        //       count++;
        //       //如果是最后一张,则隐藏等待中  
        //       if (count == tempFilePaths.length) {
        //         wx.hideToast();
        //       }
        //       wx.showToast({
        //         title: '上传成功',
        //         icon: '',
        //         mask: true,
        //         duration: 1500
        //       })
        //       console.log(res);
        //        console.log(res.data);
        //     },
        //     fail: function (res) {
        //       wx.hideToast();
        //       wx.showModal({
        //         title: '错误提示',
        //         content: '上传图片失败',
        //         showCancel: false,
        //         success: function (res) { }
        //       })
        //     }
        //   });
        // }
      }
    })
  },
  /**
   * 预览下载的图片
   */
  // preview_download_picture: function () {
  //   wx.previewImage({
  //     current: this.data.downloadPicturePath,
  //     urls: this.data.downloadPicturePath,
  //   })
  // },
  /**
   * 下载图片方法
   */
  // download: function () {
  //   var that = this;
  //   wx.downloadFile({
  //     url: "https://uncle-justice.top/zerg/public/index.php/api/v1/excel", //仅为示例，并非真实的资源
  //     success: function (res) {
  //       console.log(res)
  //       // 只要服务器有响应数据，就会把响应内容写入文件并进入 success 回调，业务需要自行判断是否下载到了想要的内容
  //       if (res.statusCode === 200) {
  //         wx.playVoice({
  //           filePath: res.tempFilePath
  //         })
  //         wx.showToast({
  //           title: '下载成功',
  //           icon: '',
  //           mask: true,
  //           duration: 1500
  //         })
  //         that.setData({
  //           downloadPicturePath: res.tempFilePath //将下载的图片路径传给页面显示
  //         })
  //       }
        //保存下载的图片到本地
        // wx.saveImageToPhotosAlbum({
        //     filePath: res.tempFilePath,
        //   success:
        //     function (data) {
        //       console.log(data);
        //       // wx.showModal({
        //       //   title: '下载成功',
        //       //   content: '下载成功',
        //       // })
        //       wx.showToast({
        //         title: '下载成功',
        //         icon: '',
        //         mask: true,
        //         duration: 1500
        //       })  
        //       that.setData({
        //         downloadPicturePath: res.tempFilePath
        //       })
        //     },
        // })
  //     }
  //   });
  // },
  /**
   * 预览图片方法
   */
  listenerButtonPreviewImage: function (e) {
    let index = e.target.dataset.index;
    let that = this;
    wx.previewImage({
      current: that.data.tempFilePaths[0],
      urls: that.data.tempFilePaths,
      //这根本就不走
      success: function (res) {
        //console.log(res);
      },
      //也根本不走
      fail: function () {
        //console.log('fail')
      }
    })
  },

 
 
  // getNum: function (str) {
  //   var pattern = new RegExp("[0-9]+");
  //   for(var i=0;;i++){
  //   var num = str.match(pattern);
  //   return num;
  // },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {

    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
      month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
      strDate = "0" + strDate;
    }
    var today = date.getFullYear() + seperator1 + month + seperator1 + strDate;
    var temp = ['/imgs/default_cover.png']
    
    this.setData({
      date: today,
      today: today,
      tempFilePaths: temp
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function() {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function() {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function() {

  }
})