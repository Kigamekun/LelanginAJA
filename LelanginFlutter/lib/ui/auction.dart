import 'package:flutter/material.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/detail.dart';
import 'package:lelanginaja/bloc/Product_bloc.dart';
import 'package:lelanginaja/model/Product.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:lelanginaja/widget/bottombarlelangin.dart';

List list = [
  "Flutter",
  "React",
  "Ionic",
  "Xamarin",
];

class Auction extends StatefulWidget {
  Auction({Key? key}) : super(key: key);

  @override
  State<Auction> createState() => _AuctionState();
}

class _AuctionState extends State<Auction> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ListView(children: [
        Column(children: [
          Container(
            child: AppBarLelangin(),
          ),
          Container(
              margin: const EdgeInsets.all(10),
              child: Wrap(
                children: [
                  FutureBuilder<List<Product>>(
                    future: fetchProduct(),
                    builder: (context, snapshot) {
                      if (snapshot.hasData) {
                        List<Product>? history = snapshot.data;
                        return Wrap(
                            children: history!
                                .map((post) => Wrap(
                                      children: <Widget>[
                                        Card(
                                          child: Row(
                                            crossAxisAlignment:
                                                CrossAxisAlignment.center,
                                            children: <Widget>[
                                              Image.network(
                                                post.thumb,
                                                height: 150,
                                                width: 100,
                                              ),
                                              Padding(
                                                padding:
                                                    const EdgeInsets.all(8.0),
                                                child: Column(
                                                  mainAxisSize:
                                                      MainAxisSize.min,
                                                  crossAxisAlignment:
                                                      CrossAxisAlignment.start,
                                                  children: <Widget>[
                                                    SizedBox(
                                                        width: MediaQuery.of(
                                                                    context)
                                                                .size
                                                                .width *
                                                            0.5,
                                                        child: Column(
                                                            children: <Widget>[
                                                              Text(
                                                                post.name,
                                                                maxLines: 3,
                                                                overflow:
                                                                    TextOverflow
                                                                        .ellipsis,
                                                                softWrap: false,
                                                                style: const TextStyle(
                                                                    color: Colors
                                                                        .black,
                                                                    fontWeight:
                                                                        FontWeight
                                                                            .bold,
                                                                    fontSize:
                                                                        10.0),
                                                              ),
                                                              const SizedBox(
                                                                  height: 20),
                                                              Row(
                                                                  crossAxisAlignment:
                                                                      CrossAxisAlignment
                                                                          .end,
                                                                  children: <
                                                                      Widget>[
                                                                    // ElevatedButton(
                                                                    //   onPressed:
                                                                    //       () {},
                                                                    //   style: ElevatedButton
                                                                    //       .styleFrom(
                                                                    //     shape: RoundedRectangleBorder(
                                                                    //         side:
                                                                    //             const BorderSide(width: 1, color: Color(0xFF696cff)),
                                                                    //         borderRadius: BorderRadius.circular(5)),
                                                                    //     primary:
                                                                    //         Colors.white,
                                                                    //   ),
                                                                    //   child:
                                                                    //       const Text(
                                                                    //     'Save',
                                                                    //     style: TextStyle(
                                                                    //         fontSize:
                                                                    //             15,
                                                                    //         color:
                                                                    //             Color(0xFF696cff)),
                                                                    //   ),
                                                                    // ),
                                                                    const SizedBox(
                                                                        width:
                                                                            10),
                                                                    ElevatedButton(
                                                                      style: ElevatedButton
                                                                          .styleFrom(
                                                                        primary:
                                                                            const Color(0xFF696cff), // background
                                                                        onPrimary:
                                                                            Colors.white, // foreground
                                                                      ),
                                                                      onPressed:
                                                                          () {
                                                                        developer
                                                                            .log('In Click');
                                                                        Navigator.push(
                                                                            context,
                                                                            MaterialPageRoute(builder: (context) => Details(id: post.id)));
                                                                      },
                                                                      child: const Text(
                                                                          'Bid'),
                                                                    ),
                                                                  ])
                                                            ])),
                                                  ],
                                                ),
                                              ),
                                            ],
                                          ),
                                        )
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
        ])
      ]),
      bottomNavigationBar: BottomBarLelangin(active: 2),
    );
  }
}
