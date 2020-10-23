<template>
    <div>
      <div>

      </div>
      <div>
        <span>个人创建的问题中的类别分析</span>
        <hr>
        <SLineChart :all="tyList">
        </SLineChart>
        <hr>
        <CalenderHeatmap :heatmap="hList">

        </CalenderHeatmap>
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
            hList:[]
          }
      },
      methods:{
          getData:function () {
            let that = this
            that.$http.post('/yii/question/analyse/personany',{
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

            that.$http.post('/yii/question/analyse/personheat',{
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

</style>
