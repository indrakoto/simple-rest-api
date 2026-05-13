import 'package:flutter/material.dart';
import 'package:vigenesia/screen/motivasi_page.dart';
import 'package:vigenesia/screen/dashboard_page.dart';
import 'package:vigenesia/screen/login_page.dart';
import 'package:vigenesia/screen/register_page.dart';
//import 'package:vigenesia_app/screen/mainscreen_page.dart';

class MyHomePage extends StatelessWidget {
  const MyHomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      //theme:
      //    ThemeData(brightness: Brightness.dark, primaryColor: Colors.blueGrey),
      //theme: ThemeData(useMaterial3: true),
      debugShowCheckedModeBanner: false,
      home: ListMyHomePage(),
    );
  }
}

class ListMyHomePage extends StatelessWidget {
  const ListMyHomePage({super.key});

  // code
  List<Widget> _list1(BuildContext context) => <Widget>[
        ListTile(
          leading: const Icon(Icons.lock_open),
          title: const Text('Login Page'),
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const LoginPage()),
            );
          },
        ),
        const Divider(height: 0),
        ListTile(
          leading: const Icon(Icons.app_registration),
          title: const Text('Register Page'),
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const RegisterPage()),
            );
          },
          //trailing: Icon(Icons.more_vert),
        ),
        const Divider(height: 0),
        ListTile(
          leading: const Icon(Icons.view_column_sharp),
          title: const Text('View Motivasi'),
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const MotivasiPage()),
            );
          },
          //trailing: Icon(Icons.more_vert),
        ),
        const Divider(height: 0),
        ListTile(
          leading: const Icon(Icons.emoji_people_outlined),
          title: const Text('Dashboard'),
          onTap: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => const DashboardPage()),
            );
          },
          //trailing: Icon(Icons.more_vert),
        ),
        const Divider(height: 0),
      ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(title: const Text('Menu Vigenesia')),
        body: SingleChildScrollView(
          child: Container(
            color: Colors.white,
            //height: MediaQuery.of(context).size.height,
            child: Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  ListView(
                    shrinkWrap: true,
                    children: _list1(context),
                  ),
                ],
              ),
            ),
          ),
        ));
  }
}
