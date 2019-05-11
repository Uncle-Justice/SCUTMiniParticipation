import {
  Base
} from '../../utils/base.js'


class Post extends Base {
  constructor() {
    super();
  }


  getPostData(count_act, callback) {
    var params = {
      url: "recent/"+count_act,
      sCallback: function(res) {

        callback && callback(res.data);
      }
    }
    this.request(params);

  }

  // getThemeData(callback) {
  //   var param = {
  //     url: "theme?ids=1,2,3",
  //     sCallback: function (res) {
  //       callback && callback(res);
  //     }
  //   }
  //   this.request(param);

  // }

  // getProductsData(callback) {
  //   var param = {
  //     url: 'product/recent',
  //     sCallback: function (data) {
  //       callback && callback(data);
  //     }
  //   };
  //   this.request(param)
  // }
}


export {
  Post
}