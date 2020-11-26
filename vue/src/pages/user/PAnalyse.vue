<template>
    <div>
      <div class="waimian">
        <div class="back">
          <el-page-header @back="back">
          </el-page-header>
        </div>
        <div class="draw">
          <hr>
          <SLineChart :all="tyList" :title="tytitle">
          </SLineChart>
          <hr>
          <CalenderHeatmap :heatmap="hList" :title="htitle"></CalenderHeatmap>
        </div>
      </div>
    </div>
</template>

<script>
    import SLineChart from "../../components/SLineChart";
    import CalenderHeatmap from "../../components/CalenderHeatmap";
    export default {
        name: "PAnalyse",
      components: {CalenderHeatmap, SLineChart},
      data(){
          return{
            tyList:[],
            hList:[],
            tytitle:'个人创建的问题中的类别分析',
            htitle:'个人问题日历热点图'
          }
      },
      methods:{
        back:function()
        {
          this.$router.push({
            path:'/u/question',
          })
        },
          getData:function () {
            let that = this
            that.$http.post('/question/analyse/personany',{
              uid:that.$store.getters.getsId
            }).then(function (res) {
              console.log(res.data)
              that.tyList = []
              let List = res.data.data
              console.log(List)
              for(let i=0;i<List.length;i++)
              {
                that.tyList.push({
                  tyname:List[i].tyname,
                  num:List[i].num
                })
              }
              console.log(that.tyList)
            }).catch(function (err) {
              console.log(err)
            });

            that.$http.post('/question/analyse/personheat',{
              uid:that.$store.getters.getsId
            }).then(function (res) {
              console.log(res.data)
              let map  =res.data.data
              that.hList=[]
              for(let j=0;j<map.length;j++)
              {
                that.hList.push({
                  dates:map[j].key,
                  num:map[j].num
                })
              }
              console.log(that.hList)
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
