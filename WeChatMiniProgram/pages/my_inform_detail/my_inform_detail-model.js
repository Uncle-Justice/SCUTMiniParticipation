import {
  Base
} from '../../utils/base.js'


class My_inform_detail extends Base {
  constructor() {
    super();
  }


  postAlreadyData(postdata,callback) {
    var params = {
      url: "alreadyread",
      type:'POST',
      data: postdata,
      sCallback: function (res) {

        callback && callback(res.data);
      }
    }
    this.request(params);

  }
}


export {
  My_inform_detail
}