import {
  Base
} from '../../utils/base.js'


class Screen_and_inform extends Base {
  constructor() {
    super();
  }


  getPostData(count_act, callback) {
    var params = {
      url: "recent/" + count_act,
      sCallback: function(res) {

        callback && callback(res.data);
      }
    }
    this.request(params);

  }

}

export {
  Screen_and_inform
}