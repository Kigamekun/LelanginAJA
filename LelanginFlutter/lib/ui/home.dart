import 'package:flutter/material.dart';
import 'package:getwidget/getwidget.dart';

import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:lelanginaja/model/Product.dart';
import 'package:lelanginaja/bloc/Product_bloc.dart';
import 'package:lelanginaja/bloc/Banner_bloc.dart';
import 'package:lelanginaja/model/BannerLelangin.dart';

import 'dart:developer' as developer;
import 'package:lelanginaja/ui/detail.dart';

import 'package:lelanginaja/widget/bottombarlelangin.dart';
import 'package:flutter/foundation.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:flutter_countdown_timer/current_remaining_time.dart';
import 'package:flutter_countdown_timer/flutter_countdown_timer.dart';

class Home extends StatefulWidget {
  const Home({super.key});

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  String name = '';
  List<String> bannerList = [];
  @override
  void initState() {
    super.initState();
    _loadUserData();
    _loadBannerData();
  }

  _loadUserData() async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var user = jsonDecode(localStorage.getString('user').toString());

    if (user != null) {
      setState(() {
        name = user['name'];
      });
    }
  }

  _loadBannerData() async {
    final response = await http.get(
      Uri.parse(dotenv.env['API_URL'].toString() + "/api/banner"),
    );

    if (response.statusCode == 200) {
      // If the server did return a 200 OK response,
      // then parse the JSON.
      var responseJson = jsonDecode(response.body);
      List<String> banData = [];
      developer.log(responseJson['data'][0]['thumb']);
      responseJson['data'].forEach((e) {
        banData.add(e['thumb']);
      });
      // (responseJson['data'] as List).map((p) => { banData.add(p['thumb'])});
      // developer.log(banData[0]);
      setState(() {
        bannerList.addAll(banData);
      });
    } else {
      // If the server did not return a 200 OK response,
      // then throw an exception.
      throw Exception('Failed to load Banner');
    }
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        resizeToAvoidBottomInset: false,
        body: ListView(
          children: [
            Column(
              children: [
                Container(
                  child: AppBarLelangin(),
                ),
                if (bannerList.length != 0) ...[
                  GFCarousel(
                    items: bannerList.map(
                      (url) {
                        return Container(
                          margin: const EdgeInsets.all(8.0),
                          child: ClipRRect(
                            borderRadius:
                                const BorderRadius.all(Radius.circular(5.0)),
                            child: Image.network(url,
                                fit: BoxFit.cover, width: 1000.0),
                          ),
                        );
                      },
                    ).toList(),
                    onPageChanged: (index) {
                      setState(() {
                        index;
                      });
                    },
                  )
                ],
                Center(
                    child: Wrap(
                  children: [
                    FutureBuilder<List<Product>>(
                      future: fetchProduct(),
                      builder: (context, snapshot) {
                        if (snapshot.hasData) {
                          List<Product>? products = snapshot.data;
                          return Wrap(
                              children: products!
                                  .map((post) => Wrap(
                                        children: <Widget>[
                                          SizedBox(
                                            width: MediaQuery.of(context)
                                                    .size
                                                    .width *
                                                0.5,
                                            child: Card(
                                              semanticContainer: true,
                                              clipBehavior:
                                                  Clip.antiAliasWithSaveLayer,
                                              shape: RoundedRectangleBorder(
                                                borderRadius:
                                                    BorderRadius.circular(10.0),
                                              ),
                                              elevation: 5,
                                              margin: const EdgeInsets.all(10),
                                              child: Column(
                                                children: [
                                                  Image.network(post.thumb,
                                                      width: double.infinity,
                                                      height: 200),
                                                  const SizedBox(height: 10),
                                                  SizedBox(
                                                    width: 120.0,
                                                    child: Text(
                                                      post.name,
                                                      maxLines: 2,
                                                      overflow:
                                                          TextOverflow.ellipsis,
                                                      softWrap: false,
                                                    ),
                                                  ),
                                                  // const SizedBox(height: 10),
                                                  // SizedBox(
                                                  //   width: 120.0,
                                                  //   child: Text(
                                                  //     'Start From : Rp.' +
                                                  //         post.start_from
                                                  //             .toString(),
                                                  //     maxLines: 2,
                                                  //     overflow:
                                                  //         TextOverflow.ellipsis,
                                                  //     softWrap: false,
                                                  //     style: TextStyle(
                                                  //         fontSize: 11),
                                                  //   ),
                                                  // ),
                                                  const SizedBox(height: 10),
                                                  CountdownTimer(
                                                    endTime: DateTime.parse(post
                                                                .end_auction)
                                                            .millisecondsSinceEpoch +
                                                        1000 * 30,
                                                    widgetBuilder: (_,
                                                        CurrentRemainingTime?
                                                            time) {
                                                      if (time == null) {
                                                        return Opacity(
                                                            opacity: .3,
                                                            child: Row(
                                                              mainAxisAlignment:
                                                                  MainAxisAlignment
                                                                      .center,
                                                              children: [
                                                                Icon(
                                                                  Icons
                                                                      .timer_outlined,
                                                                ),
                                                                Text('EXPIRED')
                                                              ],
                                                            ));
                                                      }
                                                      return Opacity(
                                                        opacity: .3,
                                                        child: Row(
                                                            mainAxisAlignment:
                                                                MainAxisAlignment
                                                                    .center,
                                                            children: [
                                                              Icon(
                                                                Icons
                                                                    .timer_outlined,
                                                              ),
                                                              Text(
                                                                  '${time.days} d ${time.hours} h ${time.min} m ${time.sec} s')
                                                            ]),
                                                      );
                                                    },
                                                  ),
                                                  Container(
                                                    padding:
                                                        const EdgeInsets.all(
                                                            10),
                                                    child: ElevatedButton(
                                                      style: ElevatedButton
                                                          .styleFrom(
                                                        minimumSize: const Size
                                                            .fromHeight(50),
                                                        primary: const Color(
                                                            0xFF696cff), // background
                                                        onPrimary: Colors
                                                            .white, // foreground
                                                      ),
                                                      onPressed: () {
                                                        developer
                                                            .log('In Click');
                                                        Navigator.push(
                                                            context,
                                                            MaterialPageRoute(
                                                                builder: (context) =>
                                                                    Details(
                                                                        id: post
                                                                            .id)));
                                                      },
                                                      child: const Text('Bid'),
                                                    ),
                                                  )
                                                ],
                                              ),
                                            ),
                                          ),
                                        ],
                                      ))
                                  .toList());
                        }

                        return Center(
                          child: Column(
                            children: const <Widget>[
                              Padding(padding: EdgeInsets.all(50.0)),
                              CircularProgressIndicator(),
                            ],
                          ),
                        );
                      },
                    ),
                  ],
                ))
              ],
            ),
          ],
        ),
        bottomNavigationBar: BottomBarLelangin(
          active: 0,
        ),
      ),
    );
  }
}
