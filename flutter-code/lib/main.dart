import 'package:flutter/material.dart';
//import 'package:vigenesia/screen/home_page.dart';
import 'package:vigenesia/screen/login_page.dart';

void main() => runApp(const MyApp());

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
        title: 'Flutter FormBuilder Demo',
        debugShowCheckedModeBanner: false,
        //home: MyHomePage(),
        home: LoginPage());
  }
}
