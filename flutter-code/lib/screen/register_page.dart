import 'package:flutter/material.dart';
//import 'package:flutter_form_builder/flutter_form_builder.dart';
//import 'package:form_builder_validators/form_builder_validators.dart';

class RegisterPage extends StatefulWidget {
  const RegisterPage({Key? key}) : super(key: key);
  
  //final http.Client? httpClient;

  
  //const RegisterPage({
  //  this.httpClient,
  //  super.key,
  //});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  TextEditingController repasswordController = TextEditingController();
 
  @override
  Widget build(BuildContext context) {
    //final _formKey = GlobalKey<FormBuilderState>();
    final GlobalKey<FormState> _formKey = GlobalKey<FormState>();


    return Scaffold(
      appBar: AppBar(
        title: const Text('Register Page'),
      ),
      body: SingleChildScrollView(
        child: Container(
          color: Colors.white,
          height: MediaQuery.of(context).size.height,
          child: Center(
            child: Form(
              key: _formKey,
              child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children:<Widget>[
                Padding(
                  padding: const EdgeInsets.all(30),
                  /*
                  child: Image.network(
                    'https://docs.flutter.dev/assets/images/dash/dash-fainting.gif',
                    width: 200,
                  ),
                  */
                  child: Image.asset(
                    'images/hero-img.png',
                    width: 250,
                  )
                  
                ),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 100, vertical: 5),
                  child: TextFormField(
                    controller: emailController,
                    decoration: const InputDecoration(
                      enabledBorder: OutlineInputBorder(
                        borderSide: BorderSide(width: 2, color: Colors.blueAccent), //<-- SEE HERE
                      ),
                      border: OutlineInputBorder(),
                      labelText: 'Enter your email',

                    ),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 100, vertical: 5),
                  child: TextFormField(
                    controller: passwordController,
                    decoration: const InputDecoration(
                      enabledBorder: OutlineInputBorder(
                        borderSide: BorderSide(width: 2, color: Colors.blueAccent), //<-- SEE HERE
                      ),
                      border: OutlineInputBorder(),
                      labelText: 'Enter your password',
                      //labelStyle: TextStyle(
                      //  color: Colors.blueAccent,
                      //  fontSize: 24.0
                      //),
                    ),
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 100, vertical: 5),
                  child: TextFormField(
                    controller: repasswordController,
                    decoration: const InputDecoration(
                      enabledBorder: OutlineInputBorder(
                        borderSide: BorderSide(width: 2, color: Colors.blueAccent), //<-- SEE HERE
                      ),
                      border: OutlineInputBorder(),
                      labelText: 'Re-enter your password',
                      //labelStyle: TextStyle(
                      //  color: Colors.blueAccent,
                      //  fontSize: 24.0
                      //),
                    ),
                  ),
                ),                
                Container(
                  height: 50,
                  padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                  child: ElevatedButton(
                    child: const Text('Register'),
                    onPressed: () {
                      print('ini tombol register ditekan');
                      print(emailController.text);
                      print(passwordController.text);
                      print(repasswordController.text);
                    },
                  )
                ),

              ],
            ),
            )
          )
        ),
      ),

    );
  }



}
