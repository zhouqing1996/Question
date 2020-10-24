<template>
  <div>
    <div class="waimian">
      <div class="back">
        <el-page-header @back="back">
        </el-page-header>
      </div>
      <div class="draw">
        <hr>
        <SLineChart :all="atyList" :title="tytitle">
        </SLineChart>
        <hr>
        <CalenderHeatmap :heatmap="HMList" :title="htitle"></CalenderHeatmap>
      </div>
    </div>
  </div>
</template>

<script>
  import SLineChart from "../../components/SLineChart";
  import CalenderHeatmap from "../../components/CalenderHeatmap";
  export default {
    name: "Analyse",
    components: {CalenderHeatmap, SLineChart},
    data(){
      return{
        //类型数据
        atyList:[],
        //热点图数据
        HMList:[],
        tytitle:'网站中各类型问题汇总',
        htitle:"网站中问题提交日历热点图"
      }
    },
    methods:{
      back:function()
      {
        this.$router.push({
          path:'/question',
        })
      },
      getData:function () {
        let that = this
        that.$http.post('http://120.78.150.89/Question/Yii/backend/web/index.php/question/analyse/queryany',{

        }).then(function (res) {
          console.log(res.data)
          that.atyList = []
          let List = res.data.data
          console.log(List)
          for(let i=0;i<List.length;i++)
          {
            that.atyList.push({
              tyname:List[i].tyname,
              num:List[i].num
            })
          }
          console.log(that.atyList)
        }).catch(function (err) {
          console.log(err)
        });

        that.$http.post('http://120.78.150.89/Question/Yii/backend/web/index.php/question/analyse/queryheatmap',{
        }).then(function (res) {
          console.log(res.data)
          let map  =res.data.data
          that.HMList=[]
          for(let j=0;j<map.length;j++)
          {
            that.HMList.push({
              dates:map[j].key,
              num:map[j].num
            })
          }
          console.log(that.HMList)
        })
      }
    },
    created(){

    },
    mounted(){
      this.getData()
    }
  }
</script>

<style scoped>
  .back{
    margin-top: 30px;
  }
  .draw{
    margin-top: 10px;
    margin-left: 20px;
    width: auto;
    text-align: center;
  }
  .waimian{
    margin-top: 10px;
    padding: 10px;
    background-color: aliceblue;
    margin-left: 20px;
    margin-right: 20px;
    border: white;
    width: auto;
  }
</style>
