<script setup>
  import Layout from '@/Shared/Layout.vue';
  import NewQuestionModal from '@/Shared/NewQuestionModal.vue'
import { router } from '@inertiajs/vue3';
  import {ref} from 'vue'
  import {usePage} from '@inertiajs/vue3'
  import {computed} from 'vue'
  const page=usePage()
  const success=computed(()=>page.props.flash.success)
  const showNewQuestionModal=ref(false)
  const showViewQuestionModal=ref(false)
  const createdQuestion=ref(null)
  const newAnswers=ref([])
  const answers=ref([])
  const selectedAnswer=ref(null)
  const selectedQuestion=ref(null)
  let answerId=1
  function createQuestion(){
    showNewQuestionModal.value=true
  }

  function destroyModal(){
    showNewQuestionModal.value=false
    showViewQuestionModal.value=false
  }
  function addNewAnswer(){
    const newAnswer={
        id: answerId++,
        answer:'',
        correct_answer:0
    }
    
    newAnswers.value.push(newAnswer)
  }

  function handleRadioToggle(Id){
     selectedAnswer.value=Id
     newAnswers.value.forEach(answer=>{
        if(answer.id===Id){
            answer.correct_answer=1
        }else{
            answer.correct_answer=0
        }
     })
  }
  function validateAnswers(){
     for(const answer of newAnswers.value){
        if(answer.answer.trim()===''){
            return false
        }
     }
     return true
  }

  function answerCount(){
    if(newAnswers.length<4){
        alert('Four answers required to submit')
    }else if(newAnswers.length===4){
        return true
    }
    return false
  }


  function submitQuestion(){
      if(!createdQuestion.value){
        alert('Question Cannot be empty');
        return false
      }

      if(!validateAnswers() && !answerCount()){
        alert('Fill all inputs before submitting')
        return false
      }

      router.post('/questions',{
        question:createdQuestion.value,
        answers:newAnswers.value
      })

      router.on('success',()=>{
         createdQuestion.value=null,
         newAnswers.value=[]
      })
  }
  
  const props=defineProps({
     questions: Object,
     errors:Object,
  });

  function viewQuestion(index){
    showViewQuestionModal.value=true
    selectedQuestion.value=props.questions[index]
    answers.value=props.questions[index].answers
      //alert(index);
  }

  //handle radio change and submit edited answers
  const selectedEditAnswer=ref(null)
  function handleRadioChange(Id){
    selectedEditAnswer.value=Id

    answers.value.forEach(answer=>{
      if(answer.id===Id){
        answer.correct_answer=1
      }else{
        answer.correct_answer=0
      }
    })

  }
 
  //save updated answers to database

  function updateAnswers(){
    router.put('/answers',
     answers.value
    )
  }

  //edit question
  const editquestionModal=ref(false)
  const questionForEdit=ref(null)
  function editQuestion(index){
    questionForEdit.value=props.questions[index]
    //alert(index)
  }

  function updateQuestion(){
     router.put('/questions',
     questionForEdit.value
     )
  }

  //delete question
 function deleteQuestion(id){
   router.on('before',()=>{
    return confirm('You are about to delete a record, are you sure')
   })

   router.delete('/questions/'+id)
 }
</script>
<template>
  <Layout>
    <button @click="createQuestion" class="btn btn-success">Create</button>
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(question,index) in questions">
      <th scope="row">{{index+1}}</th>
      <td>{{question.question }}</td>
      <td>
        <button @click="viewQuestion(index)" class="btn btn-primary">View</button>
        <button @click="editquestionModal=true,editQuestion(index)" class="btn btn-success">Edit</button>
        <button @click="deleteQuestion(question.id)" class="btn btn-danger">Delete</button>
      </td>
      
    </tr>
    </tbody>
    </table>


    <Teleport to="body">
       <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
        <template #header>
            <h5>Add New Question</h5>
            
        </template>
        <template #success>
          <div v-if="success" class="alert alert-success">{{success}}</div>
        </template>
        <template #body>
            <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> Question</label>
                <input type="text" v-model="createdQuestion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Answers</th>
      <th scope="col">Correct ?</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(answer,index) in newAnswers">
      <th scope="row">{{answer.id}}</th>
      <td>
        <input type="text" v-model="answer.answer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
      </td>
      <td>
        <input :checked="answer.correct_answer ===1" class="form-check-input" :value="answer.id" @change="handleRadioToggle(answer.id)" type="radio">
      </td>
    </tr>
   </tbody>
   </table>
            </form>
          </template>
          <template #footer>
            <span @click="addNewAnswer" v-if="newAnswers.length<4"><h3>+</h3></span>
            <button @click="destroyModal" class="btn btn-danger">Close</button>
            <button v-if="newAnswers.length>3" @click="submitQuestion" class="btn btn-success">Submit</button>
        </template>
       </NewQuestionModal>

       <NewQuestionModal :show="showViewQuestionModal" @close="destroyModal">
        <template #header>
         <h5>View Question/Answers</h5>
        </template>
        <template #success>
          <div v-if="success" class="alert alert-success">{{success}}</div>
        </template>
        <template #body>
           <p><strong>Q.{{selectedQuestion.question}}</strong></p>
    
          <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Answers</th>
              <th scope="col">Correct ?</th>
            </tr>
          </thead>
            <tbody>
            <tr v-for="(answer,index) in answers">
              <th scope="row">{{index+1}}</th>
              <td>
                <input type="text" v-model="answer.answer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </td>
              <td>
                <input :checked="answer.correct_answer ===1" class="form-check-input" :value="answer.id" @change="handleRadioChange(answer.id)" type="radio">
              </td>
            </tr>
          </tbody>
          </table>
        </template>
        <template #footer>
           <button @click="destroyModal" class="btn btn-danger">Close</button>
           <button @click="updateAnswers"  class="btn btn-success">Update</button>
        </template>
      </NewQuestionModal>

      <NewQuestionModal :show="editquestionModal" @click="aditQuestionModal=false">
        <template #header>
          <h5>Edit Question</h5>
        </template>
        <template #success>
          <div v-if="success" class="alert alert-success">{{success}}</div>
        </template>
        <template #body>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Question</label>
            <input v-model="questionForEdit.question" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
        </template>
        <template #footer>
          <button @click="editquestionModal=false" class="btn btn-danger">Close</button>
           <button @click="updateQuestion"  class="btn btn-success">Update</button>
        </template>
      </NewQuestionModal>
    </Teleport>
  </Layout>
</template>