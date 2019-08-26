<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home!</div><br>

                    <div class="card-body">
                        <a :href="'http://localhost:3000/api/members?api_token=' + api_token">メンバー一覧</a>
                    </div><br>

                    <div class="card-body">
                        Member:{{ member }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : {
            member : String,
            api_token : String
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
