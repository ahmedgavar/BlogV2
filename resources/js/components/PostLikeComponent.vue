<template>
<div>


    <div class="mt-3 d-flex">
        <div
             class="px-1" v-for="(count,reaction) in reaction_Summary"
              :key="reaction"
              v-show="count"

            >
            <img  style="width: 20px;" :src="Image(reaction)" />
            <span class="px-1">{{count}}</span>
        </div>




</div>

    <div class="position-relative">

        <!-- i used v-show and default is false to hide reaction until user enters like -->
        <div
            class="position-absolute border rounded shadow-sm bg-white"
            style="bottom: 30px;"
            v-show="show_reactions_types"
            >
                <button
                    class=" mr-2 btn btn-sm btn-outline-danger d-inline font-weight-bold"
                    @click="toggle_reaction(type)"
                      v-for="type in types" :key="type">
                    <img :src="Image(type)">

                </button>


        </div>
            <!-- toggle show reactions on click -->

        <span>
            <button @click="show_reactions_types =! show_reactions_types"

                 class="mr-2 btn btn-sm btn-outline-primary d-inline font-weight-bold"
                >
                    <span v-if="auth_reaction">
                        <img :src="Image(auth_reaction)" class="w-25">
                        {{ auth_reaction }}

                    </span>
                    <span v-else>
                        like
                    </span>

            </button>

        </span>
   </div>
</div>
</template>

<script>
import axios from 'axios'

    export default {
        props:['summary','reacted','post_id'],
        data(){
            return{
                show_reactions_types:false,
                types:['like','love','haha','angry','sad','wow'],
                reaction_Summary:{...this.summary},
                auth_reaction:this.reacted?this.reacted.type: null,
            }
        },
        methods:
        {
            Image(type){
            return `/assets/reactions/reactions_${type}.png`

        },
        toggle_reaction(reaction){


            let path=window.location.href+'posts/'+this.post_id+'/reaction';
            let old_reaction=this.auth_reaction;

            axios.post(`${path}`,{reaction}).catch(()=>{

            this.save_reaction(old_reaction,reaction);


            });

            this.show_reactions_types=false;
            this.save_reaction(reaction,old_reaction);





        },
        save_reaction(new_reaction,old_reaction){
            this.resetReactionSummary(new_reaction,old_reaction);
             if(this.auth_reaction===new_reaction){
                this.auth_reaction=null;
                return;
            }
            else{
            this.auth_reaction=new_reaction;


            }


        },
        resetReactionSummary(new_reaction,old_reaction){

            if(old_reaction){
                this.reaction_Summary[old_reaction]--;
            }
            if(new_reaction  &&new_reaction !==old_reaction){
                if(!this.reaction_Summary[new_reaction]){
                    this.reaction_Summary[new_reaction]=1;
                    return;
                }
                this.reaction_Summary[new_reaction]++;
            }


        }
    }}
</script>
