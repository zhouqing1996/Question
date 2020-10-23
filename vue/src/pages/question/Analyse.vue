<template>
  <div>
    <div>

    </div>
    <div>
      <span>所有用户的数据分类整合</span>

      <SLineChart :all="atyList">
      </SLineChart>
      <hr>
      <!--<span>所有用户累计提交问题热点图</span>-->
      <CalenderHeatmap :heatmap="HMList"></CalenderHeatmap>
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
        HMList:[]
      }
    },
    methods:{
      getData:function () {
        let that = this
        that.$http.post('/yii/question/analyse/queryany',{
          uid:that.$store.getters.getsId
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

        that.$http.post('/yii/question/analyse/queryheatmap',{
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

</style>
