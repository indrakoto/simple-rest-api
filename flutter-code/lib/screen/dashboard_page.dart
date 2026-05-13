import 'package:flutter/material.dart';
//import 'package:flutter_form_builder/flutter_form_builder.dart';
//import 'package:form_builder_validators/form_builder_validators.dart';
//import 'package:vigenesia_app/screen/login_page.dart';
import 'package:vigenesia/screen/motivasi_page.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({Key? key}) : super(key: key);

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: const Text('Dashboard Page'),
          automaticallyImplyLeading: false,
        ),
        body: SingleChildScrollView(
          child: Container(
            color: Colors.white,
            height: MediaQuery.of(context).size.height,
            child: Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  Padding(
                    padding: const EdgeInsets.symmetric(vertical: 1, horizontal: 1),
                    child: Image.network(
                      'https://avatars.githubusercontent.com/u/2908275?v=4',
                      width: 300,
                    ),
                  ), //utk gambar

                  const Padding(
                    padding: EdgeInsets.symmetric(vertical: 10, horizontal: 1),
                    child: Text(
                      'Indra Chaidir',
                      style:
                          TextStyle(fontSize: 22, fontWeight: FontWeight.w500),
                    ),
                  ),
                  Container(
                  height: 50,
                  padding: const EdgeInsets.fromLTRB(10, 10, 10, 0),
                  child: ElevatedButton(
                    child: const Text('Lihat Motivasi'),
                    onPressed: () => {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const MotivasiPage()),
                      ),
                    },

                  )
                ), //utk text nama

                   //padding utk form builder
                ],
              ),
            ),
          ),
        ));
  }
}
