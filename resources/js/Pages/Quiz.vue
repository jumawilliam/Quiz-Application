<script setup>
 import Layout from '@/Shared/Layout.vue'
import { router } from '@inertiajs/vue3';
 import {ref,computed} from 'vue'
 const props=defineProps({
    questions:Object
 })
 const currentIndex=ref(0)
 const totalQuestions=computed(()=>props.questions.length)
 const currentQuestion= computed(()=>{
    return props.questions[currentIndex.value]
 })
 const isLastQuestion=computed(()=>currentIndex.value===props.questions.length-1)

 const answers=computed(()=>{
    return props.questions[currentIndex.value].answers
 })


 const selectedAnswer=ref(null)
 const result=ref(0)
 function selectedOption(index){
    //alert(index)
   selectedAnswer.value=index
 }

 function nextQuestion(){
   if(selectedAnswer.value !==null){

     if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==1){
        result.value++;
     }
     currentIndex.value++;
     selectedAnswer.value=null
   }
 }

 function calculateResult(){
    if(props.questions[currentIndex.value].answers[selectedAnswer.value].correct_answer==1){
        result.value++;
     }
    
     router.post('/results',[
        {
            results:{
                'score':result.value,
                'totalQuestions':totalQuestions.value
            }
        }
     ])
 }

</script>
<template>
  <Layout>
    <div class=" d-flex justify-content-center ">Question {{currentIndex+1}} out of {{totalQuestions}}</div>
    <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
  <div class="list-group">
    <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
          <h6 class="mb-0">{{currentQuestion.question}}</h6>
        </div>
      </div>
    </a>
    <a @click="selectedOption(index)" v-for="(answer,index) in answers"  :class="{'selected': index===selectedAnswer}" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      <div  class="d-flex gap-2 w-100 justify-content-between">
        <div  >
          <p class="mb-0 opacity-75">{{ answer.answer }}</p>
        </div>
      </div>
    </a>
    <div>
    <button @click="nextQuestion" v-if="!isLastQuestion" class="btn btn-primary">Next</button>
    <button @click="calculateResult" v-if="isLastQuestion" class="btn btn-success">Submit</button>
</div>
  </div>
</div>

  </Layout>
</template>

<style scoped>
 .selected{
  background-color:green;
  color:white;
 }
</style>